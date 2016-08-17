<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\common\assets\order\OrderCreateAsset::register($this);

$this->title = 'Создание нового заказа для клиента';

$model = $this->context->model;

$this->context->addBreadCrumb('Вернуться к карточке клиента', ['/order/client/view', 'id' => $model->clientId]);
$this->context->addBreadCrumb($this->title);
?>

<?php
$options = ['class' => 'form-control'];
$form = ActiveForm::begin(['id' => 'createOrderForm']);

echo $form->field($model, 'clientId')->label(false)->hiddenInput();
?>

<div class="row">
    <div class="col-md-4">
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
        <?= \common\components\helpers\FormButton::getButtons(['create-by-client']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

