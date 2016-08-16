<?php
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;

/** @var \common\models\order\Order $model */
$model = $this->context->model;
if (!$model->checkAccessManageOrder()) {
    return;
}

$currentOrderStage = $model->currentOrderStage;

$accessToCall = ArrayHelper::getValue($currentOrderStage, 'stage.call');
?>

<div class="borderedBlock orderInnerBlock">
    <?php if ($accessToCall) : ?>
        <button class="btn btn-block btn-primary callOrder">Позвонить</button>
        <!--    <button class="btn btn-block btn-default sendSmsOrder">Отправить смс</button>-->

        <div class="clearfix">&nbsp;</div>
    <?php endif; ?>

    <?php
    if (!empty($currentOrderStage)) {
        $processStages = $currentOrderStage->getProcessStage();
        if (!empty($processStages)) {
            foreach ($processStages->actions as $stageAction) {
                echo Html::button($stageAction->action->name, [
                    'class'       => 'btn btn-block btn-default stageActionButton',
                    'data-action' => $stageAction->action_id,
                ]);
            }
        }
    }
    ?>
</div>