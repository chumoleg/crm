<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'modalInnerForm']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'price', ['skipFormLayout' => true])->textInput(['placeholder' => 'Цена ...']); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'currency', ['skipFormLayout' => true])->dropDownList(
                \common\components\nomenclature\Currency::$currencyList); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'type', ['skipFormLayout' => true])->dropDownList(
                \common\models\product\ProductPrice::$typeList); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>