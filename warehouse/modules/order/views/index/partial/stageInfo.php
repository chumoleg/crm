<?php
use common\components\helpers\ArrayHelper;
use common\components\helpers\TimeHelper;

/** @var \warehouse\models\order\Order $model */
$model = $this->context->model;

if (!empty($model->process_id)) {
    $orderStageHistory = [];
    foreach ($model->orderStages as $orderStage) {
        $stage = $orderStage->stage_id;
        if (isset($orderStageHistory[$stage])) {
            $orderStageHistory[$stage]['spentTime'] += $orderStage->time_spent;

        } else {
            $orderStageHistory[$stage] = [
                'name'       => $orderStage->stage->name,
                'timeCreate' => strtotime($orderStage->date_create),
                'spentTime'  => $orderStage->time_spent,
                'timeLimit'  => $orderStage->time_limit,
            ];
        }

        $current = $orderStage->status == \common\components\Status::STATUS_ACTIVE;
        $orderStageHistory[$stage]['current'] = $current;

        $overdue = ArrayHelper::getValue($orderStageHistory[$stage], 'overdue', false);
        $orderStageHistory[$stage]['overdue'] = !$overdue ? $orderStage->overdue : true;

        if ($current && $orderStage->time_limit > 0) {
            $orderStageHistory[$stage]['spentTime'] = $orderStageHistory[$stage]['spentTime'] + time()
                - strtotime($orderStage->date_create);
        }
    }
}
?>

<div class="borderedBlock topBlock stageHistoryBlock text-center">
    <div class="innerStageHistoryBlock">
        <?php if (!empty($orderStageHistory)) : ?>
            <?php foreach ($orderStageHistory as $item) : ?>
                <?php
                $cssClass = 'label-primary';
                if ($item['current']) {
                    $cssClass = 'label-success';
                    if ($item['overdue']) {
                        $cssClass = 'label-warning';
                    }

                } elseif ($item['overdue']) {
                    $cssClass = 'label-danger';
                }

                $text = '<div class="orderStageHistoryRow">' . $item['name'] . '</div>';

                $needle = TimeHelper::secondsToString($item['timeLimit']);
                if (!empty($needle)) {
                    $text .= 'Необходимо: ' . $needle . '<br />';
                    $showSeconds = true;
                    if ($item['spentTime'] > 60) {
                        $showSeconds = false;
                    }

                    $text .= 'Затрачено: ' . TimeHelper::secondsToString($item['spentTime'], $showSeconds);
                }
                ?>

                <span class="label full-width <?= $cssClass; ?>"><?= $text; ?></span>
                <div class="clearfix"></div>
            <?php endforeach; ?>

        <?php else : ?>
            <h5>Процесс обработки не найден</h5>
        <?php endif; ?>
    </div>
</div>