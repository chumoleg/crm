<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'layout'              => '@app/views/layouts/main',
    'modules'             => [
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
    'params' => $params,
];
