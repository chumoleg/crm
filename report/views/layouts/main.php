<?php
$items = [
    [
        'label'  => 'По сделкам (в разрезе клиентов)',
        'url'    => ['/client/index'],
    ],
    [
        'label'  => 'По времени обработки сделок',
        'url'    => ['/time/index'],
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);