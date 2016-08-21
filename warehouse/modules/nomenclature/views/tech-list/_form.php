<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список тех.листов', ['/nomenclature/tech-list/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(); ?>
        </div>
        <div class="col-md-7 col-md-offset-1">
            <?= $this->render('partial/_components', ['form' => $form]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>