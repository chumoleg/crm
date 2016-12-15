<?php
/** @var \common\models\order\Order $model */
$model = $this->context->model;
?>

<table class="table table-condensed">
    <thead>
    <tr>
        <th>ID</th>
        <th>наименование</th>
        <th>кол-во</th>
        <th>цена</th>
        <th></th>
    </tr>
    </thead>

    <?php foreach ($model->orderProducts as $rel) : ?>
        <tr data-id="<?= $rel->id; ?>">
            <td><?= $rel->product_id; ?></td>
            <td><?= $rel->product->name; ?>
                <?= $this->render('_productDescription', ['description' => $rel->product->description]); ?>
            </td>
            <td><?= $rel->quantity; ?></td>
            <td><?= Yii::$app->formatter->asDecimal($rel->price, 2); ?></td>
            <td>
                <?php if ($model->checkAccessManageOrder()) : ?>
                    <a href="javascript:;" class="btn btn-xs btn-danger">
                        <i class="glyphicon glyphicon-remove removeOrderProduct"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tfoot>
    <tr>
        <th colspan="3" class="text-right">Итого:</th>
        <th><?= Yii::$app->formatter->asDecimal($model->price, 2); ?></th>
        <th></th>
    </tr>
    </tfoot>
</table>