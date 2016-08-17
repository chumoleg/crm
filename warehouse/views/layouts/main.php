<?php
$items = [
    [
        'label'  => 'Заказы',
        'url'    => ['/order/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/tag')
    ],
    [
        'label'  => 'Тэги',
        'url'    => ['/tag/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/tag')
    ],
    [
        'label'  => 'Товары',
        'url'    => ['/product/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/product')
    ]
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);