<?php
$url = Yii::$app->request->url;

$items = [
    [
        'label'  => 'Сделки',
        'url'    => ['/order/order/index'],
        'active' => (bool)strstr($url, '/order/')
    ],
    [
        'label'  => 'Управление (общее)',
        'items' => [
            [
                'label'  => 'Организации',
                'url'    => ['/common/company/index'],
                'active' => (bool)strstr($url, 'common/company')
            ],
            [
                'label'  => 'Пользователи',
                'url'    => ['/common/user/index'],
                'active' => (bool)strstr($url, 'common/user/')
            ],
            [
                'label'  => 'Источники',
                'url'    => ['/common/source/index'],
                'active' => (bool)strstr($url, 'common/source/')
            ],
            [
                'label'  => 'Товары',
                'url'    => ['/common/product/index'],
                'active' => (bool)strstr($url, 'common/product')
            ],
            [
                'label'  => 'Тэги',
                'url'    => ['/common/tag/index'],
                'active' => (bool)strstr($url, 'common/tag')
            ],
        ],
        'active' => (bool)strstr(Yii::$app->request->url, '/common/')
    ],
    [
        'label'  => 'Управление бизнес-процессами',
        'items' => [
            [
                'label'  => 'Действия',
                'url'    => ['/process/action/index'],
                'active' => (bool)strstr($url, 'process/action/')
            ],
            [
                'label'  => 'Причины для действий',
                'url'    => ['/process/reason/index'],
                'active' => (bool)strstr($url, 'process/reason/')
            ],
            [
                'label'  => 'Статусы сделок',
                'url'    => ['/process/stage/index'],
                'active' => (bool)strstr($url, 'process/stage/')
            ],
            [
                'label'  => 'Процессы обработки сделок',
                'url'    => ['/process/process/index'],
                'active' => (bool)strstr($url, 'process/process')
            ],
        ],
        'active' => (bool)strstr(Yii::$app->request->url, '/process/')
    ],
    [
        'label'  => 'Управление внешними системами',
        'url'    => ['/system/system/index'],
        'active' => (bool)strstr(Yii::$app->request->url, '/system/')
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);