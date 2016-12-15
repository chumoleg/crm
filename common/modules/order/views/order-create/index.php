<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\common\assets\order\OrderCreateAsset::register($this);

$this->title = 'Заключение новой сделки';

$this->context->addBreadCrumb('Список сделок', ['/order/order/index']);
$this->context->addBreadCrumb($this->title);

$model = $this->context->model;
?>

<?php
$options = ['class' => 'form-control'];
$form = ActiveForm::begin(['id' => 'createOrderForm']);
?>

<div class="row">
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'source')->widget(\kartik\widgets\Select2::className(), [
                    'data' => \common\models\source\Source::getList(),
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'company')->widget(\kartik\widgets\Select2::className(), [
                    'data' => \common\models\company\Company::getList(),
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'typePayment')->dropDownList(
                    \common\components\nomenclature\TypePayment::$list); ?>
            </div>
        </div>
    </div>

    <div class="col-md-5">
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
        <?= \common\components\helpers\FormButton::getButtons(['order/index']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

