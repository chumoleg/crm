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

<!-- top tiles -->
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Всего контактов</span>
        <div class="count"><?= $data['countClients']; ?></div>
        <span class="count_bottom"></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Всего сделок</span>
        <div class="count"><?= $data['countOrders']; ?></div>
        <span class="count_bottom"></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Активные сделки</span>
        <div class="count green"><?= $data['countActive']; ?></div>
        <span class="count_bottom">Из них просрочено: <i class="red"><?= $data['countActiveOverdue']; ?>
                (<?= $percentOverdue; ?>%)</i></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Закрытые сделки</span>
        <div class="count"><?= $data['countClosed']; ?></div>
        <span class="count_bottom"><i class="green"><?= $percentClosed; ?>% </i> от общего кол-ва сделок</span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Отклоненные сделки</span>
        <div class="count"><?= $data['countRejected']; ?></div>
        <span class="count_bottom"><i class="green"><?= $percentRejected; ?>% </i> от общего кол-ва сделок</span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Контакты без сделок</span>
        <div class="count red"><?= $data['countClientsWithoutOrders']; ?></div>
        <span class="count_bottom"><i class="red"><?= $percentWithoutOrders; ?>
                % </i> от общего кол-ва контактов</span>
    </div>
</div>
<!-- /top tiles -->