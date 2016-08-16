<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список процессов', ['/management/process/process/index']);
$this->context->addBreadCrumb($this->title);

\backend\modules\management\modules\process\assets\ProcessAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-11">
                    <?php
                    echo $form->field($model, 'type')->dropDownList(\common\models\process\Process::$typeList);
                    echo $form->field($model, 'name')->textInput();

                    echo $form->field($model, 'sourceList')->widget(\kartik\widgets\Select2::className(), [
                        'data'    => \common\models\source\Source::getList(),
                        'options' => [
                            'multiple'    => true,
                            'placeholder' => '',
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>

        <div class="col-md-10">
            <?= $this->render('partial/_form-stages', ['form' => $form]); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>