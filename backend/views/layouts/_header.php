<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
    'brandLabel' => 'Management',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => [
        [
            'label' => 'Управление (общее)',
            'url'   => ['/common/user/index'],
            'active' => (bool)strstr(Yii::$app->request->url, '/common/')
        ],
        [
            'label' => 'Управление бизнес-процессами',
            'url'   => ['/process/action/index'],
            'active' => (bool)strstr(Yii::$app->request->url, '/process/')
        ],
        [
            'label' => 'Управление внешними системами',
            'url'   => ['/system/system/index'],
            'active' => (bool)strstr(Yii::$app->request->url, '/system/')
        ],
        [
            'label' => 'Выход',
            'url'   => '/site/logout',
        ]
    ]
]);
NavBar::end();