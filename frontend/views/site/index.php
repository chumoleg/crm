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
            'href'  => 'http://call.' . Yii::$app->urlManager->baseUrl,
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

    <div class="row">
        <div class="col-md-12">
            <?php foreach ($modules as $module) : ?>
                <a href="<?= $module['href']; ?>">
                <div class="col-md-4">
                    <div class="well frontModulesBlock">
                        <?= $module['label']; ?>
                    </div>
                </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>