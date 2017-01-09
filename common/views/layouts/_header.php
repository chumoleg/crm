<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

if (Yii::$app->id != 'app-frontend') {
    if (\common\models\user\User::isAdmin()) {
        $menuItems[] = [
            'label' => 'Выход из раздела',
            'url'   => 'http://' . Yii::$app->params['baseUrl']
        ];
    } else {
        $menuItems[] = [
            'label' => 'Выход',
            'url'   => \yii\helpers\Url::to(['/site/logout'])
        ];
    }
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $menuItems
]);
NavBar::end();