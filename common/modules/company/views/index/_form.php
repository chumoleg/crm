<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;
use common\modules\company\forms\CompanyForm;
use common\models\user\User;

/** @var CompanyForm $model */
$model = $this->context->model;

$this->context->addBreadCrumb('Список организаций', ['/company/index/index']);
$this->context->addBreadCrumb($this->title);

\common\assets\FormAppendAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-md-3">
            <?php
            if (User::isOperator()) {
                echo Html::hiddenInput('CompanyForm[type]', CompanyForm::TYPE_CUSTOMER);
            } else {
                echo $form->field($model, 'type')->dropDownList(CompanyForm::$typeList);
            }
            ?>

            <?= $form->field($model, 'name')->textInput(); ?>

            <?= $form->field($model, 'brand')->textInput(); ?>

            <?php
            if (User::isOperator()) {
                echo Html::hiddenInput('CompanyForm[current_operator]', Yii::$app->user->id);
            } else {
                echo $form->field($model, 'current_operator')->dropDownList(
                    $model->getOperatorList(), ['prompt' => '...']);
            }
            ?>
        </div>

        <div class="col-md-8 col-md-offset-1">
            <?= $this->render('_form-contacts', ['form' => $form]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>