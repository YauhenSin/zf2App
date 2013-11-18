<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'work' => 'Work\Controller\WorkController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'work' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/work',
                    'constrains' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Work\Controller\Work',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'controller' => 'work',
                                'action'     => 'add',
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/show',
                            'defaults' => array(
                                'controller' => 'work',
                                'action'     => 'show',
                            ),
                        ),
                    ),
                ),
            ),
            'names' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/names/[/:name]',
                    'defaults' => array(
                        'controller' => 'Work\Controller\Work',
                        'action' => 'names',
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'work_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Work/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Work\Entity' => 'work_entities'
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'work' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);