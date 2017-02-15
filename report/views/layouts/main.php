<?php
$items = [
    [
        'label' => 'По сделкам (в разрезе клиентов)',
        'url'   => ['/client/index'],
        'icon'  => 'bar-chart-o',
    ],
    [
        'label' => 'По времени обработки сделок',
        'url'   => ['/time/index'],
        'icon'  => 'bar-chart-o',
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);