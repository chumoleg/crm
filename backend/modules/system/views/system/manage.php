<?php

$this->title = 'Настройка параметров системы ' . $this->context->model->name;

$this->context->addBreadCrumb('Список систем', ['/management/system/system/index']);
$this->context->addBreadCrumb($this->title);
?>

<div class="row">
    <div class="col-md-3">
        <?= \yii\bootstrap\Tabs::widget([
            'id'           => 'systemTabs',
            'encodeLabels' => false,
            'items' => [
                [
                    'label'   => 'Статусы',
                    'content' => $this->render('partial/_statuses'),
                    'active'  => true,
                ],
                [
                    'label'   => 'URLs',
                    'content' => $this->render('partial/_urls'),
                ],
                [
                    'label'   => 'Товары',
                    'content' => $this->render('partial/_products'),
                ],
            ],
            'options'      => [
                'class' => 'nav nav-tabs'
            ]
        ]); ?>
    </div>
</div>