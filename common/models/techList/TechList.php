<?php

namespace common\models\techList;

use common\components\base\ActiveRecord;
use common\models\product\ProductTechList;

/**
 * This is the model class for table "wh_tech_list".
 *
 * @property integer                    $id
 * @property string                     $name
 * @property string                     $date_create
 *
 * @property ProductTechList[]          $productTechLists
 * @property TechListProductComponent[] $techListProductComponents
 */
class TechList extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_tech_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 300]
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
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTechLists()
    {
        return $this->hasMany(ProductTechList::className(), ['tech_list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechListProductComponents()
    {
        return $this->hasMany(TechListProductComponent::className(), ['tech_list_id' => 'id']);
    }
}
