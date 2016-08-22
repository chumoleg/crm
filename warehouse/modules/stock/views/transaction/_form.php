<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список операций', ['/stock/transaction/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'type')->dropDownList(
                \warehouse\models\transaction\Transaction::$typeList,
                ['disabled' => !$model->getIsNewRecord()]); ?>
            <?= $form->field($model, 'name')->textInput(['disabled' => !$model->getIsNewRecord()]); ?>
        </div>
        <div class="col-md-7 col-md-offset-1">
            <?php
            if ($model->getIsNewRecord()) {
                echo $this->render('partial/_form-components', ['form' => $form]);
            } else {
                echo $this->render('partial/_table-components');
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>