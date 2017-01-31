<?php
$this->title = 'Отчет "По сделкам (в разрезе клиентов)"';
?>

<div class="row">
    <div class="col-md-6">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th>Клиент</th>
                <th>Всего</th>
                <th>Активных</th>
                <th>Закрытых</th>
                <th>Отклоненных</th>
            </tr>
            </thead>

            <?php foreach ($data as $item) : ?>
                <tr>
                    <td><?= $item['companyName']; ?></td>
                    <td><?= $item['countAll']; ?></td>
                    <td><?= $item['countAll'] - $item['countClosed'] - $item['countRejected']; ?></td>
                    <td><?= $item['countClosed']; ?></td>
                    <td><?= $item['countRejected']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>