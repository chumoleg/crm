<div class="row">
    <div class="col-md-1 col-sm-4 col-xs-12">

    </div>

    <div class="col-md-7 col-sm-4 col-xs-12">

    </div>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <div class="text-center borderedBlock">
            <?php
            echo Yii::$app->getUser()->getIdentity()->email;
            $workPlace = Yii::$app->getUser()->getWorkPlace();
            if (!empty($workPlace)) {
                echo ' (' . $workPlace . ')';
            }
            ?>
        </div>
    </div>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <?php if (Yii::$app->getUser()->can(\common\components\Role::ADMIN)) : ?>
            <a href="<?= 'http://' . Yii::$app->params['baseUrl']; ?>"
               class="btn btn-default mainMenuButton">Выход из раздела</a>
        <?php else : ?>
            <a href="<?= \yii\helpers\Url::to(['/site/logout']); ?>"
               class="btn btn-default mainMenuButton">Выход</a>
        <?php endif; ?>
    </div>
</div>