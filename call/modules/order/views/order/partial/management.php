<?php
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;

/** @var \common\models\order\Order $model */
$model = $this->context->model;
if (!$model->checkAccessManageOrder()) {
    return;
}

$currentStage = $model->currentStage;
$accessToCall = ArrayHelper::getValue($currentStage, 'call');
?>

<div class="borderedBlock orderInnerBlock">
    <?php if ($accessToCall) : ?>
        <button class="btn btn-block btn-primary callOrder">Позвонить</button>
        <!--    <button class="btn btn-block btn-default sendSmsOrder">Отправить смс</button>-->

        <div class="clearfix">&nbsp;</div>
    <?php endif; ?>

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