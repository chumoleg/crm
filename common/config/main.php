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
            ]
        ],
        'curl'        => [
            'class' => 'linslin\yii2\curl\Curl',
        ],
        'mailer'      => [
            'class'    => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
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
