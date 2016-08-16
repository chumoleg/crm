<?php
use yii\helpers\Html;

$this->beginContent('@common/views/layouts/base.php');
?>

<?= $this->render('_header'); ?>
    <div class="clearfix"></div>

<?php
echo (!empty($this->title)) ? Html::tag('legend', $this->title) : null;

if (!empty($this->context->breadCrumbs)) {
    echo \yii\widgets\Breadcrumbs::widget([
        'links' => $this->context->breadCrumbs,
    ]);
}

echo $content;

$this->endContent();