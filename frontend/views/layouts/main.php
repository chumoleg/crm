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
        'icon'  => 'gears',
    ],
    [
        'label' => 'Склад',
        'url'   => 'http://' . Yii::$app->params['warehouseUrl'],
        'icon'  => 'archive',
    ],
    [
        'label' => 'Отчеты',
        'url'   => 'http://' . Yii::$app->params['reportUrl'],
        'icon'  => 'bar-chart',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);