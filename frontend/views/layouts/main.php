<?php
$items = [];

if (Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $items[] = ['label' => 'Logout (' . Yii::$app->user->identity->email . ')', 'url' => ['/site/logout']];
}

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);