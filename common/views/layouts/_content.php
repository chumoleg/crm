<?php
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-sm-12">
        <?php if (!empty($this->title)) : ?>
            <legend><?= Html::encode($this->title); ?></legend>
        <?php endif; ?>

        <?php
        if (!empty($this->context->breadCrumbs)) {
            echo \yii\widgets\Breadcrumbs::widget([
                'links' => $this->context->breadCrumbs,
            ]);
        }
        ?>

        <?= \common\components\widgets\Alert::widget(); ?>
        <?= $content; ?>
    </div>
</div>