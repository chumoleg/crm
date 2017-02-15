<?php
$items = [
    [
        'label' => 'CRM',
        'url'   => 'http://' . Yii::$app->params['callUrl'],
        'icon'  => 'table',
    ],
    [
        'label' => 'Админка',
        'url'   => 'http://' . Yii::$app->params['backendUrl'],
        'icon'  => 'edit',
    ],
    [
        'label' => 'Склад',
        'url'   => 'http://' . Yii::$app->params['warehouseUrl'],
        'icon'  => 'sitemap',
    ],
    [
        'label' => 'Отчеты',
        'url'   => 'http://' . Yii::$app->params['reportUrl'],
        'icon'  => 'bar-chart-o',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);