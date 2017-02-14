<?php

\call\assets\AppAsset::register($this);

$items = [
    [
        'label'  => 'Сделки',
        'url'    => ['/order/order/index'],
    ],
    [
        'label'  => 'Контакты',
        'url'    => ['/company/index/index'],
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);