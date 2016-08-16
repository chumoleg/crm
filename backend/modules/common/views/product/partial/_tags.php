<?php
use yii\helpers\Html;

$data = [];
foreach ($model->productTags as $productTag) {
    $tag = $productTag->tag;
    $data[] = Html::tag('span', $tag->name, ['class' => 'tableLabel label ' . $tag->label_class]);
}

echo implode(' ', $data);