<?php
use common\components\nomenclature\Currency;
use common\models\product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
            <td>
                <?php
                $price = $obj->price . ' ' . ArrayHelper::getValue(Currency::$currencyList, $obj->currency);
                echo Html::a($price, 'javascript:;', ['class' => 'addProductToOrder', 'data-id' => $obj->id]);
                ?>
            </td>
            <td><?= ArrayHelper::getValue(Product::$categoryList, $obj->product->category); ?></td>
            <td><?= $obj->product->name; ?>
                <?= $this->render('@app/modules/order/views/order/partial/_productDescription',
                    ['description' => $obj->product->description]); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>