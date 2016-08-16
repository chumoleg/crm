<?php
$items = [
    [
        'label'  => 'Управление (общее)',
        'url'    => ['/common/user/index'],
        'active' => (bool)strstr(Yii::$app->request->url, '/common/')
    ],
    [
        'label'  => 'Управление бизнес-процессами',
        'url'    => ['/process/action/index'],
        'active' => (bool)strstr(Yii::$app->request->url, '/process/')
    ],
    [
        'label'  => 'Управление внешними системами',
        'url'    => ['/system/system/index'],
        'active' => (bool)strstr(Yii::$app->request->url, '/system/')
    ],
    [
        'label' => 'Выход',
        'url'   => '/site/logout',
    ]
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);