<?php
return [
    'components' => [
        'db'     => [
            'dsn'      => 'mysql:host=localhost;dbname=crm',
            'username' => 'root',
            'password' => 'root',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
    ],
];