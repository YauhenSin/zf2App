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
use Zend\View\Model\JsonModel;

class WorkController extends AbstractActionController
{
    public function showAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $artistId = $this->getServiceLocator()->get('zfcuserauthservice')->getIdentity()->getId();
        $works = $objectManager->getRepository('\Work\Entity\Work')->findBy(array('artistId' => $artistId));
        return array(
            'imagePath' => $_SERVER['DOCUMRNT_ROOT'].'/uploads/works/' . $artistId,
            'works' => $works,
        );
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
                if($adapter->isValid()) {

                    if($adapter->receive($post['workImage']['name'])) {
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
        $request = $this->getRequest();
        if ($request->isPost()) {
            return new JsonModel(array('0' => $this->params()->fromPost('workGenre')));
        }


        $works = $objectManager->getRepository('\Work\Entity\Work')->findAll();

        $genres = $objectManager->getRepository('\Work\Entity\Genre')->findAll();
        $result = array();
        foreach ($genres as $genre) {
            $result[$genre->getId()] = $genre->getName();
        }
        $form = new WorkForm();
        return array(
            'form' => $form,
            'imagePath' => $_SERVER['DOCUMRNT_ROOT'].'/uploads/works/',
            'works' => $works,
            'genre' => $result,
        );
    }
}