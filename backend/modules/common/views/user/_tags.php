<?php
use yii\helpers\Html;

$data = [];
foreach ($model->userTags as $userTag) {
    $tag = $userTag->tag;
    $data[] = Html::tag('span', $tag->name, ['class' => 'tableLabel label ' . $tag->label_class]);
}

echo implode(' ', $data);