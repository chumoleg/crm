<?php

\call\assets\AppAsset::register($this);

$items = [
    [
        'label' => 'Сделки',
        'url'   => ['/order/order/index'],
        'icon'  => 'table',
    ],
    [
        'label' => 'Контакты',
        'url'   => ['/company/index/index'],
        'icon'  => 'users',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);