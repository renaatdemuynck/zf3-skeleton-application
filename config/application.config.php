<?php

return [
    'modules' => [
        'Zend\Mvc\I18n',
        'Zend\I18n',
        'Zend\Router',
        'Zend\Navigation',
        'Application'
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,' . @APP_ENV . ',local}.config.php'
        ],
        'module_paths' => [
            './module',
            './vendor'
        ]
    ]
];
