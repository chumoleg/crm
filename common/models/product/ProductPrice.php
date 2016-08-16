<?php

namespace common\models\product;

use \common\components\base\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "product_price".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string  $price
 * @property integer $currency
 * @property integer $type
 * @property integer $status
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property Product $product
 * @property User    $user
 */
class ProductPrice extends ActiveRecord
{
    const TYPE_MAIN = 1;
    const TYPE_ADDITIONAL = 2;

    public static $typeList
        = [
            self::TYPE_MAIN       => 'Для создания заказов',
            self::TYPE_ADDITIONAL => 'Для доп.продаж'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'currency', 'type'], 'filter', 'filter' => 'trim'],
            [['product_id', 'price', 'type'], 'required'],
            [['product_id', 'currency', 'type', 'status', 'user_id'], 'integer'],
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
            'product_id'  => 'Product ID',
            'price'       => 'Цена',
            'currency'    => 'Валюта',
            'type'        => 'Тип',
            'status'      => 'Status',
            'user_id'     => 'User ID',
            'date_create' => 'Date Create',
        ];
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

    public static function findByType($type)
    {
        return self::find()->andWhere(['type' => $type])->all();
    }
}
