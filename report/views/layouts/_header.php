<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
    'brandLabel' => 'Reports',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => [
        [
            'label'  => 'По времени обработки заказов',
            'url'    => ['/time/index'],
            'active' => (bool)strstr(Yii::$app->request->url, 'report/time/')
        ],
        [
            'label' => 'Выход',
            'url'   => '/site/logout',
        ]
    ]
]);
NavBar::end();