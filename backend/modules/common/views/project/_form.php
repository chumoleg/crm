<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список тегов', ['/common/project/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'label_class')->dropDownList(\common\models\project\Project::$labelClassList); ?>
        <?= $form->field($model, 'comment')->textarea(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <?= \common\components\helpers\FormButton::getButtons(); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>