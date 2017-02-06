<?php
$data = \common\components\helpers\DashboardHelper::getData();
if (empty($data)) {
    return;
}

$percentOverdue = !empty($data['countActive']) ? round($data['countActiveOverdue'] / $data['countActive'] * 100, 2) : 0;
$percentClosed = !empty($data['countOrders']) ? round($data['countClosed'] / $data['countOrders'] * 100, 2) : 0;
$percentRejected = !empty($data['countOrders']) ? round($data['countClosed'] / $data['countOrders'] * 100, 2) : 0;
$percentWithoutOrders = !empty($data['countClients']) ? round($data['countClientsWithoutOrders']
    / $data['countClients'] * 100, 2) : 0;
?>

<table class="table table-bordered table-dashboard">
    <tr>
        <td>Всего контактов</td>
        <td><strong><?= $data['countClients']; ?></strong></td>
        <td></td>
    </tr>
    <tr>
        <td>Всего сделок</td>
        <td><strong><?= $data['countOrders']; ?></strong></td>
        <td></td>
    </tr>
    <tr>
        <td>Активные сделки</td>
        <td><strong><?= $data['countActive']; ?></strong></td>
        <td>Из них просрочено: <strong><?= $data['countActiveOverdue']; ?></strong>
            (<strong><?= $percentOverdue; ?>%</strong>)</td>
    </tr>
    <tr>
        <td>Закрытые сделки</td>
        <td><strong><?= $data['countClosed']; ?></strong></td>
        <td><strong><?= $percentClosed; ?>%</strong> от общего кол-ва сделок</td>
    </tr>
    <tr>
        <td>Отклоненные сделки</td>
        <td><strong><?= $data['countRejected']; ?></strong></td>
        <td><strong><?= $percentRejected; ?>%</strong> от общего кол-ва сделок</td>
    </tr>
    <tr>
        <td>Контакты без сделок</td>
        <td><strong><?= $data['countClientsWithoutOrders']; ?></strong></td>
        <td><strong><?= $percentWithoutOrders; ?>%</strong> от общего кол-ва контактов</td>
    </tr>
</table>
