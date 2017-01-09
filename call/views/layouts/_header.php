<div class="fixed-block">
    <div class="text-center borderedBlock">
        <?php
        echo Yii::$app->user->identity->email;
        $workPlace = Yii::$app->user->getWorkPlace();
        if (!empty($workPlace)) {
            echo ' (' . $workPlace . ')';
        }
        ?>
    </div>

    <div>
        <?php if (\common\models\user\User::isAdmin()) : ?>
            <a href="<?= 'http://' . Yii::$app->params['baseUrl']; ?>"
               class="btn btn-default mainMenuButton">Выход из раздела</a>
        <?php else : ?>
            <a href="<?= \yii\helpers\Url::to(['/site/logout']); ?>"
               class="btn btn-default mainMenuButton">Выход</a>
        <?php endif; ?>
    </div>
</div>