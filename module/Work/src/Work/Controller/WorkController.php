<?php

namespace Work\Controller;

use Work\Entity\Work as EntityWork;
use Work\Form\WorkForm;
use Work\Model\Work;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\Date;
use Zend\Validator\File\Count;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\View\Model\ViewModel;

class WorkController extends AbstractActionController
{
    public function showAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $artistId = $this->getServiceLocator()->get('zfcuserauthservice')->getIdentity()->getId();
        $works = $objectManager->getRepository('\Work\Entity\Work')->findBy(array('artistId' => $artistId));
        $worksView = new ViewModel();
        $worksView->setTemplate('work/work/works');
        $worksView->setVariables(array(
            'imagePath' => $_SERVER['DOCUMRNT_ROOT'].'/uploads/works/',
            'works' => $works,
        ));
        $showView = new ViewModel();
        $showView->setTemplate('work/work/show');
        $showView->addChild($worksView, 'worksView');
        return $showView;
    }

    public function addAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $request = $this->getRequest();
        $form = new WorkForm();
        if ($request->isPost()) {
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $work = new Work();
            $form->setInputFilter($work->getInputFilter());
            $form->setData($post);
            if ($form->isValid()) {
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $size = new Size(array('min' => 10, 'max' => 10000000));
                $count = new Count(array('min' => 0, 'max' => 1));
                $extension = new Extension(array('extension' => array('jpg', 'jpeg', 'png')));
                $objDateTime = new \DateTime('now');
                $artistId = $this->getServiceLocator()->get('zfcuserauthservice')->getIdentity()->getId();
                $path = getcwd() . "/public/uploads/works/" . $artistId;
                if (!is_dir($path)) {
                    if (!@mkdir($path, 0777, true)) {
                        throw new \Exception("Unable to create destination: " . $path);
                    }
                }
                $pictureHash = md5($objDateTime->getTimestamp() . $path);
                $pictureExt = array_pop(explode('.', $post['workImage']['name']));
                $filter = new \Zend\Filter\File\Rename($path . "/" . $pictureHash . "." . $pictureExt);
                $adapter->setDestination($path);
                $adapter->setFilters(array($filter), $post['workImage']);
                $adapter->setValidators(array($size, $count, $extension), $post['workImage']);
                if($adapter->isValid() && $adapter->receive($post['workImage']['name'])) {
                    $newWork = new EntityWork();
                    $formData = $form->getData();
                    $newWork->setArtistId($artistId);
                    $newWork->setName($formData['workName']);
                    $newWork->setDescription($formData['workDescription']);
                    $newWork->setPictureHash($pictureHash . '.' . $pictureExt);
                    $newWork->setPictureName($post['workImage']['name']);
                    $newWork->setPrice($formData['workPrice']);
                    $newWork->setGenre($objectManager->getRepository('\Work\Entity\Genre')->findOneBy(array('id' => $formData['workGenre'])));
                    $objectManager->persist($newWork);
                    $objectManager->flush();
                    return $this->redirect()->toRoute('work/show');
                }
            }
        }
        $genres = $objectManager->getRepository('\Work\Entity\Genre')->findAll();
        $result = array();
        foreach ($genres as $genre) {
            $result[$genre->getId()] = $genre->getName();
        }
        return array('form' => $form, 'genre' => $result);
    }

    public function searchAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $workGenre = $this->params()->fromPost('workGenre');
        $workPrice = $this->params()->fromPost('workPrice');
        if ($workGenre) {
            $works = $objectManager->getRepository('\Work\Entity\Work')->createQueryBuilder('w')
                ->where('w.price >= :minPrice')
                ->andWhere('w.price <= :maxPrice')
                ->andWhere('w.genre = :genre')
                ->setParameters(array(
                    'minPrice' => $workPrice[0],
                    'maxPrice' => $workPrice[1],
                    'genre' => $objectManager->getRepository('\Work\Entity\Genre')->findOneBy(array('id' => $workGenre))
                ))
                ->orderBy('w.price', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            $works = $objectManager->getRepository('\Work\Entity\Work')->createQueryBuilder('w')
                ->where('w.price >= :minPrice')
                ->andWhere('w.price <= :maxPrice')
                ->setParameters(array(
                    'minPrice' => $workPrice[0],
                    'maxPrice' => $workPrice[1],
                ))
                ->orderBy('w.price', 'ASC')
                ->getQuery()
                ->getResult();
        }
        $worksView = new ViewModel();
        $worksView->setTemplate('work/work/works');
        $worksView->setVariables(array(
            'imagePath' => $_SERVER['DOCUMRNT_ROOT'].'/uploads/works/',
            'works' => $works,
        ));
        if ($this->getRequest()->isXmlHttpRequest()) {
            $worksView->setTerminal(true);
            return $worksView;
        }
        $genres = $objectManager->getRepository('\Work\Entity\Genre')->findAll();
        $genreList = array();
        foreach ($genres as $genre) {
            $genreList[$genre->getId()] = $genre->getName();
        }
        $form = new WorkForm();
        $searchView = new ViewModel();
        $searchView->setTemplate('work/work/search');
        $searchView->setVariables(array(
            'form' => $form,
            'genreList' => $genreList,
        ));
        $searchView->addChild($worksView, 'worksView');
        return $searchView;
    }
}