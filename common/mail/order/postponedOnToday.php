<?php
use yii\helpers\Html;
use common\components\helpers\ArrayHelper;

echo Html::tag('h4', 'На сегодня отложено сделок: ' . count($orderData));
?>

<table>
    <?php foreach ($orderData as $order) : ?>
        <?php $orderId = $order['id']; ?>
        <td><?= $orderId; ?></td>
        <td><?= ArrayHelper::getValue($order, 'companyCustomer.currentOperator.fio'); ?></td>
        <td><?= Html::a($orderId, 'http://call.crm.local/order/order/view/' . $orderId); ?></td>
    <?php endforeach; ?>
</table>