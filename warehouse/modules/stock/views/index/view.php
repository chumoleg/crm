<?php
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\DetailView;
use warehouse\models\transaction\Transaction;
use common\components\helpers\DatePicker;

$this->title = $model->name;

$this->context->addBreadCrumb('Наличие комплектующих на складе', ['/stock/index/index']);
$this->context->addBreadCrumb($this->title);

$currentStock = $model->getCurrentStock();

echo DetailView::widget([
    'model'      => $model,
    'attributes' => [
        'id',
        'name',
        [
            'attribute' => 'id',
            'label'     => 'Текущий остаток',
            'value'     => \yii\helpers\ArrayHelper::getValue($currentStock, 'quantity', 0)
        ]
    ],
]);
?>
    <div class="clearfix">&nbsp;</div>
<?php
Pjax::begin(['id' => 'transaction-grid']);
echo GridView::widget([
    'dataProvider' => $dataProviderTransaction,
    'filterModel'  => $modelTransaction,
    'columns'      => [
        'id',
        [
            'attribute' => 'type',
            'filter'    => Transaction::$typeList,
            'value'     => function ($model) {
                return \yii\helpers\ArrayHelper::getValue(Transaction::$typeList, $model->type);
            }
        ],
        'name',
        [
            'attribute' => 'date_create',
            'format'    => 'datetime',
            'filter'    => DatePicker::getInput($modelTransaction)
        ],
        [
            'label' => 'Кол-во',
            'value' => function ($data) use ($model) {
                $counts = 0;
                foreach ($data->transactionProductComponents as $transactionProductComponent) {
                    if ($transactionProductComponent->product_component_id == $model->id) {
                        $counts += $transactionProductComponent->quantity;
                    }
                }

                return $data->type == Transaction::TYPE_INCOME ? $counts : -$counts;
            }
        ],
//        [
//            'class'    => 'common\components\grid\ActionColumn',
//            'template' => '{view}',
//        ],
    ],
]);
Pjax::end();