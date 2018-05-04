<?php

return [
    'controllers' => [
        'invokables' => [
            'User\Controller\Index' => 'User\Controller\IndexController',
            'User\Controller\Register' => 'User\Controller\RegisterController',
            'User\Controller\Login' => 'User\Controller\LoginController',
        ]
    ],
    'router' => [
        'routes' => [
            'users' => [
                'type'    => 'Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/users',
                    'defaults' => [
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => []
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'user' => __DIR__ . '/../view',
        ],
    ],
];
