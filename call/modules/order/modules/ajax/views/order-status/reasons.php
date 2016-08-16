<?php if (empty($actionReasons)) : ?>
    <div class="row">
        <div class="col-md-12">
            <?= \yii\helpers\Html::button('Отложить', [
                'class'       => 'btn btn-default btn-block changeStatusButton',
                'data-action' => $action->id,
                'data-reason' => null,
            ]); ?>
        </div>
    </div>

    <?php return; ?>
<?php endif; ?>

<?php foreach ($actionReasons as $actionReason) : ?>
    <div class="row">
        <div class="col-md-12">
            <?= \yii\helpers\Html::button($actionReason->reason->name, [
                'class'       => 'btn btn-default btn-block changeStatusButton',
                'data-action' => $action->id,
                'data-reason' => $actionReason->reason_id,
            ]); ?>
        </div>
    </div>
<?php endforeach; ?>