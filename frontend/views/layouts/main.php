<?php
$items = [];

if (Yii::$app->getUser()->getIsGuest()) {
    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $items[] = ['label' => 'Logout (' . Yii::$app->getUser()->getIdentity()->email . ')', 'url' => ['/site/logout']];
}

echo $this->render('@common/views/layouts/main', ['menuItems' => $items, 'content' => $content]);