<?php

namespace common\models\order;

use common\components\base\ActiveRecord;
use common\models\transaction\Transaction;

/**
 * This is the model class for table "wh_order_transaction".
 *
 * @property integer     $id
 * @property integer     $order_id
 * @property integer     $transaction_id
 * @property string      $date_create
 *
 * @property Order       $order
 * @property Transaction $transaction
 */
class OrderTransaction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_order_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'transaction_id'], 'required'],
            [['order_id', 'transaction_id'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'order_id'       => 'Order ID',
            'transaction_id' => 'Transaction ID',
            'date_create'    => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }
}
