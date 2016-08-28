<?php

$config = [
    'components' => [
        'user'    => [
            'identityCookie' => [
                'domain' => '.crm.local',
            ],
        ],
        'session' => [
            'cookieParams' => [
                'domain' => '.crm.local'
            ],
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];
}

return $config;