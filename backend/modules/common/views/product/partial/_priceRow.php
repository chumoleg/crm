<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\nomenclature\Currency;
use common\models\product\ProductPrice;

/** @var ProductPrice $model */
?>

<tr class="rowForRemove">
    <td>
        <?= $model->price . ' ' . ArrayHelper::getValue(Currency::$currencyList, $model->currency); ?>
        <?= Html::hiddenInput($form . '[priceData][' . $counter . '][price]', $model->price); ?>
        <?= Html::hiddenInput($form . '[priceData][' . $counter . '][currency]', $model->currency); ?>
        <?= Html::hiddenInput('rowCounter', $counter, ['class' => 'rowCounter']); ?>
    </td>
    <td>
        <?= ArrayHelper::getValue(ProductPrice::$typeList, $model->type); ?>
        <?= Html::hiddenInput($form . '[priceData][' . $counter . '][type]', $model->type); ?>
    </td>
    <td>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', 'javascript:;', [
            'title' => 'Удалить',
            'class' => 'btn btn-default btn-sm removeRowButton',
        ]); ?>
    </td>
</tr>