<?php

return array(
    'bjyauthorize' => array(

        'default_role' => 'guest',

        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'authenticated_role' => 'user',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entity_manager.orm_default',
                'role_entity_class' => 'User\Entity\Role',
            ),
        ),

        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions unless they are specified here.
             * You may omit the 'action' index to allow access to the entire controller
             */
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'zfcuser',
                    'action' => array('index', 'changepassword', 'changeemail', 'save'),
                    'roles' => array('guest', 'user', 'artist'),
                ),
                array(
                    'controller' => 'zfcuser',
                    'action' => array('login', 'authenticate', 'register'),
                    'roles' => array('guest'),
                ),
                array(
                    'controller' => 'zfcuser',
                    'action' => array('logout'),
                    'roles' => array('user', 'artist'),
                ),

                array('controller' => 'Application\Controller\Index', 'roles' => array()),

                array(
                    'controller' => 'Album\Controller\Album',
                    'action' => array('index'),
                    'roles' => array('guest', 'user', 'artist'),
                ),

                array(
                    'controller' => 'Album\Controller\Album',
                    'action' => array('add', 'names'),
                    'roles' => array('user', 'artist'),
                ),
                array(
                    'controller' => 'work',
                    'action' => array('show', 'add'),
                    'roles' => array('artist'),
                ),
            ),
        ),
    ),
);