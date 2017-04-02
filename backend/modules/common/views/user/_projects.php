<?php
use yii\helpers\Html;

$data = [];
foreach ($model->userProjects as $userProject) {
    $project = $userProject->project;
    $data[] = Html::tag('span', $project->name, ['class' => 'tableLabel label ' . $project->label_class]);
}

echo implode(' ', $data);