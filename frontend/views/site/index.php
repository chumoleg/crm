<legend>HOME PAGE</legend>

<?php if (!Yii::$app->user->getIsGuest()) : ?>
    <?php
    $modules = [
        [
            'label' => 'Call-центр',
            'href'  => 'http://call.' . Yii::$app->params['baseUrl'],
        ],
        [
            'label' => 'Склад',
            'href'  => 'http://warehouse.' . Yii::$app->params['baseUrl'],
        ],
        [
            'label' => 'Отчеты',
            'href'  => 'http://report.' . Yii::$app->params['baseUrl'],
        ],
        [
            'label' => 'Админка',
            'href'  => 'http://backend.' . Yii::$app->params['baseUrl'],
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