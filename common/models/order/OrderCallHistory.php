<?php

namespace common\models\order;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "order_call_history".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $status
 * @property string  $date_create
 *
 * @property Order   $order
 * @property User    $user
 */
class OrderCallHistory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_call_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status'], 'required'],
            [['order_id', 'user_id', 'status'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'order_id'    => 'Order ID',
            'user_id'     => 'User ID',
            'status'      => 'Status',
            'date_create' => 'Date Create',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
