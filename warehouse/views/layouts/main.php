<?php
use yii\helpers\Html;

?>

<?php $this->beginContent('@common/views/layouts/base.php'); ?>
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

            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>