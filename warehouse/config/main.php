<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-warehouse',
    'name'                => 'Склад',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'warehouse\controllers',
    'defaultRoute'        => '/order/order/index',
    'as access'           => [
        'class' => 'common\components\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => [\common\components\Role::ADMIN, \common\components\Role::WAREHOUSE_MANAGER],
            ],
        ],
    ],
    'layout'              => '@app/views/layouts/main',
    'modules'             => [
        'order'        => [
            'basePath'          => '@common/modules/order',
            'class'             => 'common\modules\order\Module',
            'accessCreateOrder' => false,
        ],
        'nomenclature' => [
            'basePath' => '@app/modules/nomenclature',
            'class'    => 'warehouse\modules\nomenclature\Module',
        ],
        'stock'        => [
            'basePath' => '@app/modules/stock',
            'class'    => 'warehouse\modules\stock\Module',
        ],
    ],
    'params'              => $params,
];
