<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Modal;

\common\assets\AppAsset::register($this);
?>

<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>

<body>
<?php $this->beginBody(); ?>

<div class="mainContainer">
    <div class="container-fluid">
        <?= $content; ?>
    </div>
</div>

<?php
Modal::begin([
    'header'        => '<div id="modalHeaderTitle"></div>',
    'id'            => 'modalForm',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
Modal::end();
?>

<footer class="footer" id="footerElement">
    <div class="container-fluid">
        <p class="pull-left">&copy; <?= date('Y'); ?></p>

        <p class="pull-right"><?= Yii::powered(); ?></p>
    </div>
</footer>

<div id="bigPreLoader" class="text-center">
    <img src="http://<?= Yii::$app->params['baseUrl']; ?>/source/images/bigPreLoader.gif"
         alt="Пожалуйста, подождите..."/>
</div>

<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
