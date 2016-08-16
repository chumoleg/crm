<?php

namespace common\models\tag;

use \common\components\base\ActiveRecord;
use common\models\product\ProductTag;
use common\models\user\UserTag;

/**
 * This is the model class for table "tag".
 *
 * @property integer      $id
 * @property string       $name
 * @property string       $label_class
 * @property integer      $user_id
 * @property string       $date_create
 *
 * @property ProductTag[] $productTags
 * @property UserTag[]    $userTags
 */
class Tag extends ActiveRecord
{
    public static $labelClassList
        = [
            'label-default' => 'Серый',
            'label-primary' => 'Синий',
            'label-success' => 'Зеленый',
            'label-info'    => 'Голубой',
            'label-warning' => 'Оранжевый',
            'label-danger'  => 'Красный',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['label_class'], 'string', 'max' => 100]
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
            'label_class' => 'Цвет',
            'user_id'     => 'User ID',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTags()
    {
        return $this->hasMany(UserTag::className(), ['tag_id' => 'id']);
    }
}
