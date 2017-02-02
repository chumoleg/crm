<?php
use common\components\helpers\ArrayHelper;
?>

<h4>На сегодня отложено сделок: <?= count($orderData); ?></h4>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <?php $orderId = $order['id']; ?>
            <td>http://call.crm.local/order/order/view/' . <?= $order['id']; ?></td>
            <td><?= ArrayHelper::getValue($order, 'companyCustomer.currentOperator.fio'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>