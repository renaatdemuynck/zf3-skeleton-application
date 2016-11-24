<?php
namespace Application;

return [
    'translator' => [
        'locale' => 'en',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../../lang',
                'pattern' => '%s.mo'
            ],
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../../lang',
                'pattern' => '%s.php'
            ]
        ]
    ]
];
