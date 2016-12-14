<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список организаций', ['/common/company/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(); ?>
            <?= $form->field($model, 'brand')->textInput(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>