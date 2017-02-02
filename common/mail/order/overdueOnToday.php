<h4>На сегодня просрочено сделок: <?= count($orderData); ?></h4>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <td>http://call.crm.local/order/order/view/' . <?= $order['id']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>