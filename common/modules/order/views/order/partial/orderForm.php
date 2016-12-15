<?php
use yii\helpers\Html;

/** @var \common\models\order\Order $model */
$model = $this->context->model;

$disabled = !$model->checkAccessManageOrder();
?>

<?php $form = \kartik\form\ActiveForm::begin(['id' => 'orderForm']); ?>
    <div class="row">
        <div class="col-md-12">
            Организация:
            <?= $model->company->getName(); ?>

            Контактные данные:


        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Тип оплаты
        </div>
        <div class="col-md-8">
            <?= Html::dropDownList(
                'type_payment',
                $model->type_payment,
                \common\components\nomenclature\TypePayment::$list,
                ['class' => 'form-control', 'id' => 'typePayment', 'disabled' => $disabled]
            ); ?>
        </div>
    </div>
<?php $form->end(); ?>