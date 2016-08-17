<?php
$items = [
    [
        'label'  => 'Заказы',
        'url'    => ['/order/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/tag')
    ],
    [
        'label'  => 'Номенклатура',
        'items' => [
            [
                'label'  => 'Тэги',
                'url'    => ['/nomenclature/tag/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/tag')
            ],
            [
                'label'  => 'Товары',
                'url'    => ['/nomenclature/product/index'],
                'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/nomenclature/product')
            ]
        ]
    ]
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);