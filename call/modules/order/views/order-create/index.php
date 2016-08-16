<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\call\modules\order\assets\OrderCreateAsset::register($this);

$this->title = 'Создание нового заказа';

$this->context->addBreadCrumb('Список заказов', ['/order/order/index']);
$this->context->addBreadCrumb($this->title);

$model = $this->context->model;
?>

<?php
$options = ['class' => 'form-control'];
$form = ActiveForm::begin(['id' => 'createOrderForm']);
?>

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'source')->widget(\kartik\widgets\Select2::className(), [
                    'data' => \common\models\source\Source::getList(),
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'fio')->textInput(); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '+7 (999) 999-99-99',
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'addressAreaId')->widget(\kartik\widgets\Select2::className(), [
                    'data' => \common\models\geo\GeoArea::getListByRegion(),
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'addressPostIndex')->textInput(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'typeDelivery')->dropDownList(
                    \common\components\nomenclature\TypeDelivery::$list); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'deliveryPrice')->textInput(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'typePayment')->dropDownList(
                    \common\components\nomenclature\TypePayment::$list); ?>
            </div>
        </div>
    </div>

    <div class="col-md-5 col-md-offset-1">
        <?= $form->field($model, 'product_data_checker')->hiddenInput(['class' => 'productDataCheckerInput']); ?>

        <table class="table">
            <tbody id="orderProducts"></tbody>
        </table>

        <div class="clearfix"></div>
        <?= Html::button('Добавить товар', [
            'data-url'   => Url::to([
                '/order/ajax/index/product-list',
                'type' => \common\models\product\ProductPrice::TYPE_MAIN
            ]),
            'data-title' => 'Добавление товара',
            'class'      => 'showModalButton btn btn-default'
        ]); ?>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-4">
        <?= \common\components\helpers\FormButton::getButtons(); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

