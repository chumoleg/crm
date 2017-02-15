<?php

\call\assets\AppAsset::register($this);

$items = [
    [
        'label' => 'Сделки',
        'url'   => ['/order/order/index'],
        'icon'  => 'th',
    ],
    [
        'label' => 'Контакты',
        'url'   => ['/company/index/index'],
        'icon'  => 'table',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);