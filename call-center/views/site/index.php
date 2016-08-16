<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход в систему';
?>

<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <div class="containerBlock">
            <?php $form = ActiveForm::begin([
                'id'          => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                ],
            ]); ?>

            <div class="text-center"><h2>Вход в систему</h2></div>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'workPlace')->textInput(); ?>
            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'checkbox']); ?>

            <?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-block btn-primary', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>


