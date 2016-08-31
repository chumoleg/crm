<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-call-center',
    'name'                => 'Call-центр',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'call\controllers',
    'layout'              => '@app/views/layouts/main',
    'as access'           => [
        'class' => 'common\components\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => [\common\components\Role::ADMIN, \common\components\Role::OPERATOR],
            ]
        ]
    ],
    'modules'             => [
        'api'        => [
            'basePath' => '@app/modules/api',
            'class'    => 'call\modules\api\Module'
        ],
        'clientBase' => [
            'basePath' => '@app/modules/clientBase',
            'class'    => 'call\modules\clientBase\Module',
        ],
        'order'      => [
            'basePath' => '@app/modules/order',
            'class'    => 'call\modules\order\Module',
        ]
    ],
    'params'              => $params,
];
