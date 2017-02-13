<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход в систему';
?>

<?php $form = ActiveForm::begin([
    'id'          => 'login-form',
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
    ],
]); ?>

<div class="text-center"><h2>Вход в систему</h2></div>

<?= $form->field($model, 'email')
    ->label(false)
    ->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('email')]); ?>

<?= $form->field($model, 'password')
    ->label(false)
    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]); ?>

<?= $form->field($model, 'workPlace')
    ->label(false)
    ->textInput(['placeholder' => $model->getAttributeLabel('workPlace')]); ?>

<?= $form->field($model, 'rememberMe')->checkbox(['class' => 'checkbox']); ?>

<?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-block btn-primary', 'name' => 'login-button']) ?>
<?php ActiveForm::end(); ?>


