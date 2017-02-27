<?php
$url = Yii::$app->request->url;

$items = [
    [
        'label' => 'Сделки',
        'url'   => ['/order/order/index'],
        'icon'  => 'table',
    ],
    [
        'label' => 'Общие настройки',
        "url"   => "#",
        'icon'  => 'gear',
        'items' => [
            [
                'label' => 'Контакты',
                'url'   => ['/company/index/index'],
            ],
            [
                'label' => 'Пользователи',
                'url'   => ['/common/user/index'],
            ],
            [
                'label' => 'Источники',
                'url'   => ['/common/source/index'],
            ],
            [
                'label' => 'Товары',
                'url'   => ['/common/product/index'],
            ],
            [
                'label' => 'Тэги',
                'url'   => ['/common/tag/index'],
            ],
        ],
    ],
    [
        'label' => 'Процессы',
        "url"   => "#",
        'icon'  => 'sitemap',
        'items' => [
            [
                'label' => 'Действия',
                'url'   => ['/process/action/index'],
            ],
            [
                'label' => 'Причины для действий',
                'url'   => ['/process/reason/index'],
            ],
            [
                'label' => 'Статусы сделок',
                'url'   => ['/process/stage/index'],
            ],
            [
                'label' => 'Процессы обработки сделок',
                'url'   => ['/process/process/index'],
            ],
        ],
    ],
    [
        'label' => 'Внешние системы',
        'url'   => ['/system/system/index'],
        'icon'  => 'cubes',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);