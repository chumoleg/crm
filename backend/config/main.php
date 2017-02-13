<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-backend',
    'name'                => 'Админка',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log', 'common\components\AccessControl'],
    'layout'              => '@app/views/layouts/main',
    'modules'             => [
        'order'   => [
            'basePath' => '@common/modules/order',
            'class'    => 'common\modules\order\Module'
        ],
        'company' => [
            'basePath' => '@common/modules/company',
            'class'    => 'common\modules\company\Module',
        ],
        'common'  => [
            'basePath' => '@app/modules/common',
            'class'    => 'backend\modules\common\Module'
        ],
        'process' => [
            'basePath' => '@app/modules/process',
            'class'    => 'backend\modules\process\Module'
        ],
        'system'  => [
            'basePath' => '@app/modules/system',
            'class'    => 'backend\modules\system\Module'
        ],
    ],
    'params'              => $params,
];
