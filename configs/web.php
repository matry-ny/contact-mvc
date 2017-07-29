<?php

$baseDir = dirname(__DIR__);

return [
    'baseUrl' => '/contact-form',
    'db' => [
        'host' => 'localhost',
        'name' => 'contact_form',
        'user' => 'root',
        'password' => ''
    ],
    'template' => [
        'templatesDir' => "{$baseDir}/views",
        'layoutDir' => "{$baseDir}/views/layout"
    ]
];
