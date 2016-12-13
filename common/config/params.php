<?php

$domain = 'crm.thor-cpa.com';

return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'baseUrl'                       => $domain,
    'callUrl'                       => 'call.' . $domain,
    'warehouseUrl'                  => 'warehouse.' . $domain,
    'reportUrl'                     => 'report.' . $domain,
    'backendUrl'                    => 'backend.' . $domain,
    'asterisk'                      => [
        'host'     => '77.41.158.4',
        'port'     => '5038',
        'username' => 'admin',
        'password' => 'thor654321',
    ],
];