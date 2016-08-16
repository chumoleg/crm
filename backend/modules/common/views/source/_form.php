<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список источников', ['/management/common/source/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(); ?>

            <?= $form->field($model, 'systemData')->widget(\kartik\widgets\Select2::className(), [
                'data'    => \common\models\system\System::getList(),
                'options' => [
                    'multiple'    => true,
                    'placeholder' => '',
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>