<?php
use common\components\helpers\TimeHelper;

$this->title = 'Отчет "По времени обработки сделок"';
?>

<div class="row">
    <div class="col-md-6">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th>Статус</th>
                <th>Кол-во сделок</th>
                <th>Затраченное время</th>
                <th>Кол-во просрочек</th>
            </tr>
            </thead>

            <?php foreach ($data as $item) : ?>
                <tr>
                    <td><?= $item['stageName']; ?></td>
                    <td><?= $item['countOrders']; ?></td>
                    <td><?= TimeHelper::secondsToString($item['timeSpent']); ?></td>
                    <td><?= $item['countOverdue']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>