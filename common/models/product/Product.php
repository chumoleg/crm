<?php

namespace common\models\product;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\order\OrderProduct;

/**
 * This is the model class for table "product".
 *
 * @property integer        $id
 * @property string         $name
 * @property string         $article
 * @property string         $description
 * @property integer        $category
 * @property integer        $status
 * @property integer        $user_id
 * @property string         $date_create
 *
 * @property OrderProduct[] $orderProducts
 * @property User           $user
 * @property ProductPrice[] $productPrices
 * @property ProductTag[]   $productTags
 */
class Product extends ActiveRecord
{
    const CATEGORY_PRODUCT = 1;
    const CATEGORY_SERVICE = 2;

    public static $categoryList
        = [
            self::CATEGORY_PRODUCT => 'Товар',
            self::CATEGORY_SERVICE => 'Услуга',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category'], 'required'],
            [['description'], 'string'],
            [['category', 'status', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['article'], 'string', 'max' => 100],
            ['article', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'article'     => 'Артикул',
            'description' => 'Описание',
            'category'    => 'Категория',
            'status'      => 'Статус',
            'user_id'     => 'Создан',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPrices()
    {
        return $this->hasMany(ProductPrice::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['product_id' => 'id']);
    }
}
