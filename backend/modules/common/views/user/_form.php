<?php
use kartik\form\ActiveForm;

$model = $this->context->model;

$this->context->addBreadCrumb('Список пользователей', ['/common/user/index']);
$this->context->addBreadCrumb($this->title);
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?php
            echo $form->field($model, 'email')->textInput();
            echo $form->field($model, 'password')->passwordInput();
            echo $form->field($model, 'role')->dropDownList(\common\components\Role::$rolesList);
            echo $form->field($model, 'fio')->textInput();
            ?>
        </div>

        <div class="col-md-3 col-md-offset-1">
            <?= $form->field($model, 'tagData')->widget(
                \kartik\widgets\Select2::className(),
                [
                    'data'    => \common\models\tag\Tag::getList(),
                    'options' => [
                        'multiple'    => true,
                        'placeholder' => '',
                    ],
                ]
            ); ?>

            <?= $form->field($model, 'sourceData')->widget(
                \kartik\widgets\Select2::className(),
                [
                    'data'    => \common\models\source\Source::getList(),
                    'options' => [
                        'multiple'    => true,
                        'placeholder' => '',
                    ],
                ]
            ); ?>

            <?= $form->field($model, 'mailSendingData')->widget(
                \kartik\widgets\Select2::className(),
                [
                    'data'    => \common\components\MailSending::$typeList,
                    'options' => [
                        'multiple'    => true,
                        'placeholder' => '',
                    ],
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