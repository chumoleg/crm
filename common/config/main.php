<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'container.php');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file'  => '@yiiBase/yii'
        ],
        'db'            => [
            'class'   => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache'         => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port'     => 6379,
                'database' => 0,
            ]
        ],
        'curl'          => [
            'class' => 'linslin\yii2\curl\Curl',
        ],
        'mailer'        => [
            'class'    => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'user'          => [
            'class'           => 'common\components\base\User',
            'identityClass'   => 'common\models\user\User',
            'loginUrl'        => ['/'],
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'authManager'   => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'urlManager'    => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'              => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
            ]
        ],
        'log'           => [
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
