<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>

    HOME PAGE

<?php if (!Yii::$app->user->getIsGuest()) : ?>
    <?php
    $modules = [
        [
            'label' => 'Call-центр',
            'href'  => Url::to(['/call/']),
        ],
        [
            'label' => 'Склад',
            'href'  => Url::to(['/warehouse/']),
        ],
        [
            'label' => 'Отчеты',
            'href'  => Url::to(['/report/']),
        ],
        [
            'label' => 'Админка',
            'href'  => Url::to(['/backend/']),
        ]
    ];
    ?>

    <?php foreach ($modules as $module) : ?>
        <div class="row">
            <div class="col-md-12"><?= Html::a($module['label'], $module['href']); ?></div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>