<?php
use yii\helpers\Html;

/** @var \common\models\order\Order $model */

$data = [];
foreach ($model->getTagsFromProducts() as $tag) {
    $data[] = Html::tag('span', $tag->name, ['class' => 'tableLabel label ' . $tag->label_class]);
}

echo implode(' ', $data);