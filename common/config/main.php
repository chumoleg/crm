<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'container.php');

return [
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'language'       => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'components'     => [
        'db'          => [
            'class'   => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache'       => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port'     => 6379,
                'database' => 0,
            ],
        ],
        'curl'        => [
            'class' => 'linslin\yii2\curl\Curl',
        ],
        'mailer'      => [
            'class'         => 'yii\swiftmailer\Mailer',
            'viewPath'      => '@common/mail',
            'transport'     => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.gmail.com',
                'username'   => 'crm.sttk@gmail.com',
                'password'   => 'ge5Gr82a',
                'port'       => '587',
                'encryption' => 'tls',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => ['noreply@crm2.sttk.tv' => 'Crm Sttk'],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'log'         => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
