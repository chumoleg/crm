<?php
$items = [
    [
        'label' => 'Сделки',
        'url'   => ['/order/order/index'],
        'icon'  => 'table',
    ],
    [
        'label' => 'Номенклатура',
        'url'   => '#',
        'icon'  => 'barcode',
        'items' => [
            [
                'label' => 'Комплектующие',
                'url'   => ['/nomenclature/product-component/index'],
            ],
            [
                'label' => 'Тех.листы',
                'url'   => ['/nomenclature/tech-list/index'],
            ],
        ],
    ],
    [
        'label' => 'Учет',
        'url'   => '#',
        'icon'  => 'archive',
        'items' => [
            [
                'label' => 'Наличие на складе',
                'url'   => ['/stock/index/index'],
            ],
            [
                'label' => 'Операции',
                'url'   => ['/stock/transaction/index'],
            ],
        ],
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);