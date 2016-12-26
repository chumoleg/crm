<?php

namespace common\models\order;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\product\Product;
use common\models\user\User;
use common\models\product\ProductPrice;

/**
 * This is the model class for table "order_product".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $type
 * @property double  $price
 * @property integer $currency
 * @property integer $quantity
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property Order   $order
 * @property Product $product
 * @property User    $user
 */
class OrderProduct extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_product';
    }

    /**
     * @param Order        $order
     * @param ProductPrice $productPrice
     *
     * @return bool
     */
    public static function createByProductPrice(Order $order, ProductPrice $productPrice, $quantity = 1)
    {
        $model = new self();
        $model->order_id = $order->id;
        $model->product_id = $productPrice->product_id;
        $model->price = $productPrice->price;
        $model->currency = $productPrice->currency;
        $model->quantity = $quantity;
        $model->type = ProductPrice::TYPE_ADDITIONAL;

        return $model->save();
    }

    /**
     * @param Order $order
     * @param       $productId
     * @param       $price
     * @param       $quantity
     * @param       $currency
     *
     * @return bool
     */
    public static function addByParams(Order $order, $productId, $price, $quantity, $currency)
    {
        $model = new self();
        $model->order_id = $order->id;
        $model->product_id = $productId;
        $model->price = $price;
        $model->currency = $currency;
        $model->quantity = $quantity;
        $model->type = ProductPrice::TYPE_MAIN;

        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'type'], 'required'],
            [['order_id', 'product_id', 'type', 'currency', 'quantity', 'user_id'], 'integer'],
            [['price'], 'number'],
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
            'product_id'  => 'Product ID',
            'type'        => 'Type',
            'price'       => 'Price',
            'currency'    => 'Currency',
            'quantity'    => 'Quantity',
            'user_id'     => 'User ID',
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
