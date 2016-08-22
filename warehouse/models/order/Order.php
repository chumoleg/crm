<?php

namespace warehouse\models\order;

use common\models\stage\StageMethod;
use warehouse\models\transaction\Transaction;

/**
 * Class Order
 */
class Order extends \common\models\order\Order
{
    public function accessWarehouseTransactionWritten()
    {
        if (empty($this->currentStage)) {
            return false;
        }

        return $this->currentStage->existStageMethod(StageMethod::METHOD_WRITE_PRODUCT_COMPONENTS);
    }

    public function accessWarehouseTransactionReturn()
    {
        if (empty($this->currentStage)) {
            return false;
        }

        return $this->currentStage->existStageMethod(StageMethod::METHOD_RETURN_PRODUCT_COMPONENTS);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTransactions()
    {
        return $this->hasMany(OrderTransaction::className(), ['order_id' => 'id']);
    }

    /**
     * @return array|null|OrderTransaction
     */
    public function getWrittenOrderTransaction()
    {
        return $this
            ->getOrderTransactions()
            ->joinWith([
                'transaction' => function ($q) {
                    $q->andWhere(['type' => Transaction::TYPE_WRITTEN]);
                }
            ])
            ->one();
    }

    /**
     * @return array|null|OrderTransaction
     */
    public function getReturnOrderTransaction()
    {
        return $this
            ->getOrderTransactions()
            ->joinWith([
                'transaction' => function ($q) {
                    $q->andWhere(['type' => Transaction::TYPE_INCOME]);
                }
            ])
            ->one();
    }
}
