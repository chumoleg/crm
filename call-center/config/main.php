<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'frontend\components\UserParams'],
    'controllerNamespace' => 'frontend\controllers',
    'layout'              => '@app/views/layouts/base',
    'modules'             => [
        'api'        => [
            'basePath' => '@app/modules/api',
            'class'    => 'frontend\modules\api\Module'
        ],
        'clientBase' => [
            'basePath'  => '@app/modules/clientBase',
            'class'     => 'frontend\modules\clientBase\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
        ],
        'report'     => [
            'basePath'  => '@app/modules/report',
            'class'     => 'frontend\modules\report\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['ADMIN'],
                    ]
                ]
            ],
        ],
        'order'      => [
            'basePath'  => '@app/modules/order',
            'class'     => 'frontend\modules\order\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
        ]
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontend',
        ],
        'session'      => [
            'name' => 'advanced-frontend',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'              => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
            ]
        ],
    ],
    'params'              => $params,
];
