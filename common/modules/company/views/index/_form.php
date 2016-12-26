<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\company\forms\CompanyForm;

/** @var CompanyForm $model */
$model = $this->context->model;

$this->context->addBreadCrumb('Список организаций', ['/company/index/index']);
$this->context->addBreadCrumb($this->title);

\common\assets\FormAppendAsset::register($this);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?php
            if ($this->context->module->manageByOperator) {
                echo Html::hiddenInput('CompanyForm[type]', CompanyForm::TYPE_CUSTOMER);
            } else {
                echo $form->field($model, 'type')->dropDownList(CompanyForm::$typeList);
            }
            ?>

            <?= $form->field($model, 'name')->textInput(); ?>

            <?= $form->field($model, 'brand')->textInput(); ?>

            <?php
            if ($this->context->module->manageByOperator) {
                echo Html::hiddenInput('CompanyForm[current_operator]', Yii::$app->user->id);
            } else {
                echo $form->field($model, 'current_operator')->dropDownList(
                    $model->getOperatorList(), ['prompt' => '...']);
            }
            ?>
        </div>

        <div class="col-md-5 col-md-offset-1">
            <strong>Контакты:</strong>

            <div class="clearfix"></div>
            <table class="table">
                <tbody id="modalFormAppendResult">
                <?php
                if (!empty($model->companyContacts)) {
                    foreach ($model->companyContacts as $k => $obj) {
                        echo $this->render(
                            'partial/_contactRow',
                            [
                                'counter' => $k,
                                'model'   => $obj,
                                'form'    => $model->getReflectionClassName(),
                            ]
                        );
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="clearfix"></div>
            <?= Html::button(
                'Добавить контакт',
                [
                    'data-url'   => Url::toRoute(['/company/index/add-contact']),
                    'data-title' => 'Добавление контакта',
                    'class'      => 'showModalButton btn btn-default',
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>