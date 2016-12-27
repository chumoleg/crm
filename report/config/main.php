<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-report',
    'name'                => 'Отчеты и статистика',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'common\components\AccessControl'],
    'controllerNamespace' => 'report\controllers',
    'layout'              => '@app/views/layouts/main',
    'params'              => $params,
];
