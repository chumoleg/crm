<?php
use yii\helpers\Html;

$menuItems = $this->context->module->getMenuItems();
?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<?php if (!empty($menuItems)) : ?>
    <div class="row">
        <div class="col-sm-12">
            <?= \yii\bootstrap\Nav::widget([
                'id'           => 'managementTabs',
                'encodeLabels' => false,
                'items'        => $menuItems,
                'options'      => [
                    'class' => 'nav nav-pills'
                ]
            ]); ?>
        </div>
    </div>

    <div class="clearfix"></div>
<?php endif; ?>

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

<?php $this->endContent(); ?>