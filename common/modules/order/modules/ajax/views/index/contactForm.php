<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'companyContactForm']); ?>
    <?= $form->field($model, 'company_id', ['skipFormLayout' => true])->label(false)->hiddenInput(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'person', ['skipFormLayout' => true])->textInput(); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'type', ['skipFormLayout' => true])->dropDownList(
                \common\models\company\CompanyContact::$typeList); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'value', ['skipFormLayout' => true])->textInput(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>