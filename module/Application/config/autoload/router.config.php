<?php
namespace Application;

use Application\Controller\IndexController;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ]
];
