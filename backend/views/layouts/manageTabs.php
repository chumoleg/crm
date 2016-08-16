<?php
use yii\helpers\Html;

$this->beginContent('@common/views/layouts/base.php');
?>

<?= $this->render('_header'); ?>

<?php $menuItems = $this->context->module->getMenuItems(); ?>

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

<?= $this->render('_content', ['content' => $content]); ?>

<?php $this->endContent(); ?>