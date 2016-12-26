<?php
use common\components\nomenclature\Currency;
use common\models\product\Product;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;

/** @var \common\models\product\ProductPrice[] $productPricesList */
/** @var \yii\web\View $this */

$this->registerJs('setPopover();');

?>

<div class="row">
    <div class="col-md-12">
        <?= Html::textInput('inputSearchProduct', null,
            ['id' => 'inputSearchProduct', 'class' => 'form-control', 'placeholder' => 'Поиск...']); ?>
    </div>
</div>

<div class="clearfix"></div>

<table class="table">
    <?php foreach ($productPricesList as $obj) : ?>
        <tr class="rowProduct">
            <td><?= $obj->price . ' ' . ArrayHelper::getValue(Currency::$currencyList, $obj->currency); ?></td>
            <td><?= ArrayHelper::getValue(Product::$categoryList, $obj->product->category); ?></td>
            <td><?= $obj->product->name; ?>
                <?= $this->render('@common/modules/order/views/order/partial/_productDescription',
                    ['description' => $obj->product->description]); ?>
            </td>
            <td class="col-md-2">
                <?= Html::textInput('quantity', 1, ['class' => 'form-control']); ?>
            </td>

            <td class="col-md-1">
                <?= Html::a(Html::icon('plus'), 'javascript:;', [
                    'class'   => 'addProductToOrder btn btn-default',
                    'data-id' => $obj->id
                ]); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>