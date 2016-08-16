<?php
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;
use yii\helpers\Url;

$model = $this->context->model;
?>

<div class="borderedBlock topBlock">
    <div id="orderProductsBlock">
        <?php $model = $this->context->model; ?>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th>ID</th>
                <th>Статус</th>
                <th>Сумма</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </thead>

            <?php $sumPrices = 0; ?>
            <?php foreach ($model->orders as $order) : ?>
                <?php $currentStage = $order->currentOrderStage; ?>
                <tr data-id="<?= $order->id; ?>">
                    <td><?= $order->id; ?></td>
                    <td><?= ArrayHelper::getValue($currentStage, 'stage.name'); ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($order->price, 2); ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($order->date_create); ?></td>
                    <td>
                        <a href="javascript:;"><i class="glyphicon glyphicon-eye-open"></i></a>
                    </td>

                    <?php $sumPrices += $order->price; ?>
                </tr>
            <?php endforeach; ?>

            <tfoot>
            <tr>
                <th colspan="2" class="text-right">Итого:</th>
                <th colspan="2"><?= 'Заказов: ' . count($model->orders) . ' на общую сумму: '
                    . Yii::$app->formatter->asDecimal($sumPrices); ?></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>

    <!--    --><?php //if ($model->checkAccessManageOrder()) : ?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 text-right">
            <?= Html::a('Создать новый заказ',
                Url::to(['/order/order-create/create-by-client', 'clientId' => $model->id]),
                ['class' => 'btn btn-default']); ?>
        </div>
    </div>
    <!--    --><?php //endif; ?>
</div>