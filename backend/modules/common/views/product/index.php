<?php
/** @var \common\models\product\ProductSearch $searchModel */

use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\models\product\Product;
use yii\helpers\ArrayHelper;

$this->title = 'Список товаров';

echo $this->context->getCreateButton('Добавить новый товар');

Pjax::begin(['id' => 'productGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute'      => 'id',
            'contentOptions' => ['class' => 'idColumn'],
        ],
        'name',
        [
            'attribute' => 'category',
            'filter'    => Product::$categoryList,
            'value'     => function ($data) {
                return ArrayHelper::getValue(Product::$categoryList, $data->category);
            }
        ],
        'article',
        [
            'attribute' => 'tag',
            'filter'    => \common\models\tag\Tag::getList(),
            'format'    => 'raw',
            'value'     => function ($model) {
                return $this->render('partial/_tags', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update}',
        ],
    ],
]);
Pjax::end();