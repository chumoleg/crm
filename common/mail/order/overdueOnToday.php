<?php
use common\components\helpers\ArrayHelper;
?>

<h4>На сегодня просрочено сделок: <?= count($orderData); ?></h4>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <?php $url = 'http://call.crm.local/order/order/view/' .$order['id']; ?>
            <td><a href="<?= $url; ?>"><?= $url; ?></a></td>
            <td><?= ArrayHelper::getValue($order, 'companyCustomer.currentOperator.fio'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>