<?php

$domain = 'crm2.sttk.tv';

return \common\components\helpers\ArrayHelper::merge([
    'defaultRoute' => 'site/index',
    'bootstrap'    => ['log', 'common\components\UserParams'],
    'components'   => [
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file'  => '@yiiBase/yii',
        ],
        'user'          => [
            'class'           => 'common\components\base\User',
            'identityClass'   => 'common\models\user\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity',
                'domain'   => '.' . $domain,
//                'httpOnly' => true,
            ],
            'loginUrl'        => ['auth/login'],
        ],
        'session'       => [
            'name'         => 'advanced-session-key',
            'cookieParams' => [
                'domain'   => '.' . $domain,
                'path'     => '/',
//                'httpOnly' => true,
//                'secure'   => false,
            ],
        ],
        'urlManager'    => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'              => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
            ],
        ],
        'request'       => [
            'csrfParam'           => '_csrf-param',
            'cookieValidationKey' => '65gqHETurm6vbfvEoebgMguxh9-jZZA4',
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
                'domain' => '.' . $domain,
            ],
        ],
        'errorHandler'  => [
            'errorAction' => 'site/error',
        ],
    ],
], require('main-web-local.php'));