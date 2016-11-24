<?php
namespace Application;

use Zend\Mvc\Controller\LazyControllerAbstractFactory;

return [
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
        ]
    ],
    'view_manager' => [
        'doctype' => 'HTML5',
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
