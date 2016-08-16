<?php
$this->beginContent('@app/views/layouts/main.php');
?>
<?php $menuItems = $this->context->module->getMenuItems(); ?>

<?php if (!empty($menuItems)) : ?>
    <div class="row">
        <div class="col-sm-12">
            <?= \yii\bootstrap\Nav::widget([
                'id'           => 'managementTabs',
                'encodeLabels' => false,
                'items'        => $menuItems,
                'options'      => [
                    'class' => 'nav nav-tabs'
                ]
            ]); ?>
        </div>
    </div>

    <div class="clearfix"></div>
<?php endif; ?>

<?= $content; ?>

<?php $this->endContent(); ?>