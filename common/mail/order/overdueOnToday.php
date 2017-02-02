<?php
use yii\helpers\Html;

echo Html::tag('h4', 'На сегодня просрочено сделок: ' . count($orderData));

foreach ($orderData as $order) {
    $orderId = $order['id'];
    echo Html::a($orderId, 'http://call.crm.local/order/order/view/' . $orderId) . '<br />';
}