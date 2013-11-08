<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Entity\Album as EntityAlbum;
use Album\Model\Album;
use Album\Form\AlbumForm;

use Zend\View\Model\JsonModel;

class AlbumController extends AbstractActionController
{
    public function indexAction()
    {

    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new AlbumForm();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $newAlbum = new EntityAlbum();
                $formData = $form->getData();
                $newAlbum->setArtist($formData['artist']);
                $newAlbum->setTitle($formData['title']);
                $objectManager->persist($newAlbum);
                $objectManager->flush();
            }
        }
        return array('form' => $form);
    }

    public function namesAction()
    {
        $artistName = $this->params()->fromQuery('artistName');
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $albums = $objectManager->getRepository('\Album\Entity\Album')->createQueryBuilder('a')
            ->where('a.artist LIKE :artist')
            ->setParameter('artist', ("%" . $artistName . "%"))
            ->getQuery()
            ->getResult();
        $artists = array();
        foreach ($albums as $album) {
            $artists[] = $album->getArtist();
        }
        return new JsonModel($artists);
    }
}