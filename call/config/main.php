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
    'defaultRoute'        => '/order/order/index',
    'as access'           => [
        'class' => 'common\components\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => [\common\components\Role::ADMIN, \common\components\Role::OPERATOR],
            ],
        ],
    ],
    'modules'             => [
        'order'   => [
            'basePath' => '@common/modules/order',
            'class'    => 'common\modules\order\Module',
        ],
        'company' => [
            'basePath' => '@common/modules/company',
            'class'    => 'common\modules\company\Module',
        ],
    ],
    'params'              => $params,
];
