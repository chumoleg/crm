<?php
$items = [
    [
        'label' => 'CRM',
        'url'   => 'http://' . Yii::$app->params['callUrl'],
    ],
    [
        'label' => 'Админка',
        'url'   => 'http://' . Yii::$app->params['backendUrl'],
    ],
    [
        'label' => 'Склад',
        'url'   => 'http://' . Yii::$app->params['warehouseUrl'],
    ],
    [
        'label' => 'Отчеты',
        'url'   => 'http://' . Yii::$app->params['reportUrl'],
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);