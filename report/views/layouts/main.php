<?php
$items = [
    [
        'label'  => 'По сделкам (в разрезе клиентов)',
        'url'    => ['/client/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'report/client/')
    ],
    [
        'label'  => 'По времени обработки сделок',
        'url'    => ['/time/index'],
        'active' => (bool)strstr(Yii::$app->request->url, 'report/time/')
    ],
];

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);