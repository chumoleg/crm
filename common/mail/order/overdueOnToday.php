<?php
use yii\helpers\Html;

echo Html::tag('h4', 'На сегодня просрочено сделок: ' . count($orderData));
?>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <?php $orderId = $order['id']; ?>
            <td><?= Html::a($orderId, 'http://call.crm.local/order/order/view/' . $orderId); ?></td>
        </tr>
    <?php endforeach; ?>
</table>