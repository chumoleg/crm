<?php

namespace common\models\geo;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\order\Order;

/**
 * This is the model class for table "geo_address".
 *
 * @property integer         $id
 * @property string          $post_index
 * @property integer         $area_id
 * @property string          $city
 * @property string          $street
 * @property string          $house
 * @property string          $apartment
 * @property string          $address_hash
 * @property string          $date_create
 *
 * @property GeoArea         $area
 * @property Order[]         $orders
 */
class GeoAddress extends ActiveRecord
{
    const DEFAULT_POST_INDEX = '630100';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_address';
    }

    /**
     * @param array $attributes
     *
     * @return GeoAddress|null
     */
    public static function getByAttributes($attributes)
    {
        if (empty($attributes)) {
            return null;
        }

        $model = new self();
        $model->setAttributes($attributes);
        $model->address_hash = self::_generateHash($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    private static function _generateHash($attributes)
    {
        return md5(json_encode($attributes));
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id'], 'required'],
            [['area_id'], 'integer'],
            [['date_create', 'address_hash'], 'safe'],
            [['post_index'], 'string', 'max' => 6],
            [['street', 'city'], 'string', 'max' => 100],
            [['house', 'apartment'], 'string', 'max' => 50],
            [['address_hash'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_index'   => 'Почтовый индекс',
            'area_id'      => 'Область',
            'city'         => 'Город',
            'street'       => 'Улица',
            'house'        => 'Дом',
            'apartment'    => 'Квартира/офис',
            'address_hash' => 'Address Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(GeoArea::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['address_id' => 'id']);
    }
}
