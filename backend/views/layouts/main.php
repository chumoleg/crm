<?php
$url = Yii::$app->request->url;

$items = [
    [
        'label'  => 'Сделки',
        'url'    => ['/order/order/index'],
    ],
    [
        'label'  => 'Управление (общее)',
        "url"    => "#",
        'items'  => [
            [
                'label'  => 'Контакты',
                'url'    => ['/company/index/index'],
            ],
            [
                'label'  => 'Пользователи',
                'url'    => ['/common/user/index'],
            ],
            [
                'label'  => 'Источники',
                'url'    => ['/common/source/index'],
            ],
            [
                'label'  => 'Товары',
                'url'    => ['/common/product/index'],
            ],
            [
                'label'  => 'Тэги',
                'url'    => ['/common/tag/index'],
            ],
        ],
    ],
    [
        'label'  => 'Управление процессами',
        "url"    => "#",
        'items'  => [
            [
                'label'  => 'Действия',
                'url'    => ['/process/action/index'],
            ],
            [
                'label'  => 'Причины для действий',
                'url'    => ['/process/reason/index'],
            ],
            [
                'label'  => 'Статусы сделок',
                'url'    => ['/process/stage/index'],
            ],
            [
                'label'  => 'Процессы обработки сделок',
                'url'    => ['/process/process/index'],
            ],
        ],
    ],
    [
        'label'  => 'Управление внешними системами',
        'url'    => ['/system/system/index'],
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);