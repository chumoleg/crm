<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-api',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components'          => [
        'request'      => [
            'csrfParam'           => '_csrf-param',
            'cookieValidationKey' => '65gqHETurm6vbfvEoebgMguxh9-jZZA4'
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
    ],
    'params'              => $params,
];
