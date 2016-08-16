<?php

namespace common\models\geo;

use Yii;
use \common\components\base\ActiveRecord;

/**
 * This is the model class for table "geo_area".
 *
 * @property integer      $id
 * @property integer      $region_id
 * @property string       $name
 * @property integer      $type
 * @property string       $date_create
 *
 * @property GeoAddress[] $geoAddresses
 * @property GeoRegion    $region
 */
class GeoArea extends ActiveRecord
{
    const DEFAULT_AREA = 51;

    public static $typeList
        = [
            1 => 'Республика',
            2 => 'область',
            3 => 'край',
            4 => 'город',
            5 => 'АО',
            6 => 'АР',
            7 => 'АОбл',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_area';
    }

    /**
     * @param null|int $regionId
     *
     * @return array
     */
    public static function getListByRegion($regionId = null)
    {
        $query = self::find();
        if (!empty($regionId)) {
            $query->andWhere(['region_id' => $regionId]);
        }

        $data = $query->all();

        $array = [];
        foreach ($data as $obj) {
            $array[$obj->id] = self::getName($obj);
        }

        return $array;
    }

    /**
     * @param $obj
     *
     * @return null|string
     */
    public static function getName($obj)
    {
        if (empty($obj)) {
            return null;
        }

        return $obj->name . ' ' . self::$typeList[$obj->type];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'name', 'type'], 'required'],
            [['region_id', 'type'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'region_id'   => 'Region ID',
            'name'        => 'Name',
            'type'        => 'Type',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoAddresses()
    {
        return $this->hasMany(GeoAddress::className(), ['area_id' => 'id']);
    }
}
