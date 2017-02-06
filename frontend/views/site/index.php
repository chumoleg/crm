<legend>HOME PAGE</legend>

<?php if (\common\models\user\User::isAdmin()) : ?>
    <?php
    $modules = [
        [
            'label' => 'Call-центр',
            'href'  => Yii::$app->params['callUrl'],
        ],
        [
            'label' => 'Склад',
            'href'  => Yii::$app->params['warehouseUrl'],
        ],
        [
            'label' => 'Отчеты',
            'href'  => Yii::$app->params['reportUrl'],
        ],
        [
            'label' => 'Админка',
            'href'  => Yii::$app->params['backendUrl'],
        ],
    ];
    ?>

    <div class="row">
        <div class="col-md-4">
            <?php foreach ($modules as $module) : ?>
                <a href="<?= 'http://' . $module['href']; ?>">
                    <div class="well frontModulesBlock">
                        <?= $module['label']; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="col-md-7 col-md-offset-1">
            <?= $this->render('dashboard'); ?>
        </div>
    </div>

<?php endif; ?>