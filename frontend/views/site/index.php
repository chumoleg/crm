<?php
$this->title = 'Dashboard';

if (\common\models\user\User::isAdmin()) {
    echo $this->render('_dashboard');
}