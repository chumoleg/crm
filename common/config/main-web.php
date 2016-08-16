<?php

return [
    'defaultRoute' => 'site/index',
    'components'   => [
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file'  => '@yiiBase/yii'
        ],
        'user'          => [
            'class'           => 'common\components\base\User',
            'identityClass'   => 'common\models\user\User',
            'loginUrl'        => ['/'],
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
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
        'request'       => [
            'csrfParam' => '_csrf-param',
        ],
        'session'       => [
            'name' => 'advanced-session-key',
        ],
        'errorHandler'  => [
            'errorAction' => 'site/error',
        ],
    ],
];