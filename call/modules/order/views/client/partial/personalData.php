<?php
use yii\helpers\Html;

$model = $this->context->model;
?>

<?php $form = \kartik\form\ActiveForm::begin(['id' => 'clientForm']); ?>
    <div class="row">
        <div class="col-md-4">
            ФИО
        </div>
        <div class="col-md-8">
            <?= Html::textInput('fio', $model->getFio(), ['class' => 'form-control']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Телефон
        </div>
        <div class="col-md-8">
            <?= Html::textInput('phone', $model->getPhone(), ['class' => 'form-control']); ?>
        </div>
    </div>
<?php $form->end(); ?>