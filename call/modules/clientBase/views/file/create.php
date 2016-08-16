<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = 'Загрузка заказов из файла';

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
echo $form->field($model, 'file')->label(false)->fileInput();
echo Html::submitButton('Загрузить', ['class' => 'btn btn-primary']);

ActiveForm::end();