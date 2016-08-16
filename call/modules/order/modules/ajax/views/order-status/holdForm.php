<div class="row">
    <div class="col-md-12">
        <?= \kartik\widgets\DateTimePicker::widget(
            ['name' => 'holdTime', 'options' => ['class' => 'holdTimeInput']]); ?>
    </div>
</div>

<div class="clearfix"></div>
<?= $this->render('reasons', ['actionReasons' => $actionReasons, 'action' => $action]); ?>