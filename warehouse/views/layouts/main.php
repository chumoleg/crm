<?php
$items = [
    [
        'label'  => 'Заказы',
        'url'    => ['/order/index/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/order/index')
    ],
    [
        'label' => 'Номенклатура',
        'items' => [
            [
                'label'  => 'Тэги',
                'url'    => ['/nomenclature/tag/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/tag')
            ],
            [
                'label'  => 'Товары',
                'url'    => ['/nomenclature/product/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/product/')
            ],
            [
                'label'  => 'Комплектующие',
                'url'    => ['/nomenclature/product-component/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/product-component')
            ],
            [
                'label'  => 'Тех.листы',
                'url'    => ['/nomenclature/tech-list/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/tech-list')
            ]
        ]
    ],
    [
        'label' => 'Склад комплектующих',
        'items' => [
            [
                'label'  => 'Наличие на складе',
                'url'    => ['/stock/index/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/stock/index')
            ],
            [
                'label'  => 'Операции',
                'url'    => ['/stock/transaction/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/stock/transaction')
            ],
        ]
    ]
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);