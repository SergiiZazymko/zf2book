<?php


namespace CurrentTime;

return [
    'controllers' => [
        'invokables' => [
            'CurrentTime\Controller\CurrentTime' => 'CurrentTime\Controller\CurrentTimeController',
        ]
    ],
    'router' => [
        'routes' => [
            'user' => [
                'type'    => 'Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/current-time',
                    'defaults' => [
                        '__NAMESPACE__' => 'CurrentTime\Controller',
                        'controller'    => 'CurrentTime',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'current-time' => __DIR__ . '/../view',
        ],
    ],
];
