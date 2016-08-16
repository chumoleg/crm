<?php

namespace common\models\geo;

use \common\components\base\ActiveRecord;

/**
 * This is the model class for table "geo_region".
 *
 * @property integer      $id
 * @property string       $name
 * @property string       $date_create
 *
 * @property GeoArea[]    $geoAreas
 */
class GeoRegion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoAreas()
    {
        return $this->hasMany(GeoArea::className(), ['region_id' => 'id']);
    }
}
