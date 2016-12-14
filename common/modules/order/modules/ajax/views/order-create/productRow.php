<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\nomenclature\Currency;
?>

<tr class="rowForRemove">
    <td>
        <?= $model->product->name; ?>
        <?= Html::hiddenInput($form . '[product_data][' . $counter . '][product_id]', $model->product_id); ?>
        <?= Html::hiddenInput('rowCounter', $counter, ['class' => 'rowCounter']); ?>
    </td>
    <td>
        <?= $model->price . ' ' . ArrayHelper::getValue(Currency::$currencyList, $model->currency); ?>
        <?= Html::hiddenInput($form . '[product_data][' . $counter . '][price]', $model->price); ?>
        <?= Html::hiddenInput($form . '[product_data][' . $counter . '][currency]', $model->currency); ?>
    </td>
    <td>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', 'javascript:;', [
            'title' => 'Удалить',
            'class' => 'btn btn-default btn-sm removeRowButton',
        ]); ?>
    </td>
</tr>