<?php

namespace Work\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class WorkController extends AbstractActionController
{
    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $works = $objectManager->getRepository('\Work\Entity\Work')->findBy(array('artistId' => 2));

        return array(
            'works' => $works,
        );

    }

}