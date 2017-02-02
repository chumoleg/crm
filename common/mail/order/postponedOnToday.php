<h4>На сегодня отложено сделок: <?= count($orderData); ?></h4>

<table>
    <?php foreach ($orderData as $order) : ?>
        <tr>
            <?php $url = 'http://call.crm.local/order/order/view/' .$order['id']; ?>
            <td><a href="<?= $url; ?>"><?= $url; ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>