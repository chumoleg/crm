<?php

return [
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