<?php
namespace Application;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => UnderscoreNamingStrategy::class
            ]
        ],
        'driver' => [
            'default_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../src/Model/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model\Entity' => 'default_driver'
                ]
            ]
        ]
    ],
    'service_manager' => [
        'aliases' => [
            'entitymanager' => EntityManager::class
        ],
        'factories' => [
            UnderscoreNamingStrategy::class => InvokableFactory::class
        ]
    ]
];
