<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список тегов', ['/common/tag/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(); ?>
            <?= $form->field($model, 'label_class')->dropDownList(\common\models\tag\Tag::$labelClassList); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>