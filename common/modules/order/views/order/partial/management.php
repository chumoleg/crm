<?php
use yii\helpers\Html;

/** @var \common\models\order\Order $model */
$model = $this->context->model;
if (!$model->checkAccessManageOrder()) {
    return;
}

$currentStage = $model->currentStage;
?>

<div class="borderedBlock orderInnerBlock">
    <?php
    if (!empty($currentStage)) {
        $processStage = $model->getProcessStage();
        if (!empty($processStage)) {
            foreach ($processStage->actions as $stageAction) {
                echo Html::button($stageAction->action->name, [
                    'class'       => 'btn btn-block btn-default stageActionButton',
                    'data-action' => $stageAction->action_id,
                ]);
            }
        }
    }
    ?>
</div>