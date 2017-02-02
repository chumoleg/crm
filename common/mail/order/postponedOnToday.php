<?php
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;

echo Html::tag('h4', 'На сегодня отложено сделок: ' . count($orderData));
?>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <?php $orderId = $order['id']; ?>
            <td><?= Html::a($orderId, 'http://call.crm.local/order/order/view/' . $orderId); ?></td>
            <td><?= ArrayHelper::getValue($order, 'companyCustomer.currentOperator.fio'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>