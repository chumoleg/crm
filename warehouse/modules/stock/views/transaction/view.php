<?php
use yii\helpers\ArrayHelper;

$model = $this->context->model;
$this->title = 'Просмотр операции #' . $model->id;

$this->context->addBreadCrumb('Список операций', ['/stock/transaction/index']);
$this->context->addBreadCrumb($this->title);
?>

<div class="row">
    <div class="col-md-6">
        <strong>Тип:</strong>
        <?= ArrayHelper::getValue(\warehouse\models\transaction\Transaction::$typeList, $model->type); ?>
        <div class="clearfix"></div>
        <strong>Название:</strong>
        <?= $model->name; ?>

        <div class="clearfix"></div>
        <?= $this->render('partial/_table-components'); ?>
    </div>
</div>
