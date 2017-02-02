<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'crontask'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap'       => [
        'migrate' => [
            'class'        => 'yii\console\controllers\MigrateController',
            'templateFile' => '@console/templates/migration/templateView.php',
        ],
    ],
    'modules'             => [
        'crontask' => [
            'class'    => 'gofmanaa\crontask\Module',
            'fileName' => 'cron.txt',
            'tasks'    => [
                'sendOrderOnToday'        => [
                    'command' => 'mails/send-orders-on-today',
                    'minute'  => '0',
                    'hour'    => '4',
                ],
                'sendOverdueOrderOnToday' => [
                    'command' => 'mails/send-overdue-orders-on-today',
                    'minute'  => '5',
                    'hour'    => '4',
                ],
            ],
        ],
    ],
    'components'          => [
        'log' => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params'              => $params,
];
