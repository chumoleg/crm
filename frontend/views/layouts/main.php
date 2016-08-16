<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$this->beginContent('@common/views/layouts/base.php');

NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$items = [
    ['label' => 'Home', 'url' => ['/site/index']]
];

if (Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $items[] = ['label' => 'Logout', 'url' => ['/site/logout']];
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $items
]);
NavBar::end();

?>

<div class="mainContainer">
    <div class="container-fluid">
        <?= $content; ?>
    </div>
</div>

<?php $this->endContent(); ?>