<div class="row">
    <div class="col-md-6">
        <?= \yii\jui\DatePicker::widget(
            ['name' => 'holdDate', 'options' => ['class' => 'holdDateInput form-control', 'placeholder' => 'Дата...']]); ?>
    </div>
    <div class="col-md-6">
        <?= \yii\bootstrap\Html::dropDownList('holdTime', null, \common\components\helpers\TimeHelper::getTimesArray(),
            ['class' => 'holdTimeInput form-control', 'prompt' => 'Время...']); ?>
    </div>
</div>

<div class="clearfix"></div>
<?= $this->render('reasons', ['actionReasons' => $actionReasons, 'action' => $action]); ?>