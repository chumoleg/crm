<?php
$items = [
    [
        'label'  => 'Tags',
        'url'    => ['/tag/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/tag')
    ],
    [
        'label'  => 'Products',
        'url'    => ['/product/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'warehouse/product')
    ]
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);