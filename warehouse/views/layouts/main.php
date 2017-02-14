<?php
$items = [
    [
        'label' => 'Сделки',
        'url'   => ['/order/order/index'],
    ],
    [
        'label' => 'Номенклатура',
        'url'   => '#',
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
        'label' => 'Склад комплектующих',
        'url'   => '#',
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