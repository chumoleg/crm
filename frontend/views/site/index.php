<?php if (\common\models\user\User::isAdmin()) : ?>
    <?php
    $modules = [
        [
            'label' => 'CRM',
            'href'  => Yii::$app->params['callUrl'],
        ],
        [
            'label' => 'Админка',
            'href'  => Yii::$app->params['backendUrl'],
        ],
        [
            'label' => 'Склад',
            'href'  => Yii::$app->params['warehouseUrl'],
        ],
        [
            'label' => 'Отчеты',
            'href'  => Yii::$app->params['reportUrl'],
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