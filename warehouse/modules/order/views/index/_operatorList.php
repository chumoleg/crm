<?= \yii\helpers\Html::dropDownList('operatorList', $model->current_user_id, $operatorList,
    ['class' => 'form-control setOperatorForOrder', 'prompt' => '...', 'data-order-id' => $model->id]); ?>