<?php

$domain = 'lisscrm.ru';

$config = [
    'components' => [
        'user'    => [
            'identityCookie' => [
                'domain' => '.' . $domain,
            ],
        ],
        'session' => [
            'cookieParams' => [
                'domain' => '.' . $domain
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