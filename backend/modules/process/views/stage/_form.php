<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список статусов', ['/process/stage/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?php
            echo $form->field($model, 'name')->textInput();
            echo $form->field($model, 'alias')->textInput();
            echo $form->field($model, 'department')->dropDownList(
                \common\components\helpers\DepartmentHelper::$departmentList);

            echo $form->field($model, 'methodData')->widget(\kartik\widgets\Select2::className(), [
                'data'    => \common\models\stage\StageMethod::$methodList,
                'options' => [
                    'multiple'    => true,
                    'placeholder' => '',
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>