<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-warehouse',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'warehouse\controllers',
    'layout'              => '@app/views/layouts/main',
    'modules'             => [
        'order'        => [
            'basePath' => '@app/modules/order',
            'class'    => 'warehouse\modules\order\Module'
        ],
        'nomenclature' => [
            'basePath' => '@app/modules/nomenclature',
            'class'    => 'warehouse\modules\nomenclature\Module'
        ],
        'stock'        => [
            'basePath' => '@app/modules/stock',
            'class'    => 'warehouse\modules\stock\Module'
        ],
    ],
    'params'              => $params,
];
