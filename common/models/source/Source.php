<?php

namespace common\models\source;

use common\components\base\ActiveRecord;
use common\models\order\Order;
use common\models\process\ProcessSource;

/**
 * This is the model class for table "source".
 *
 * @property integer         $id
 * @property string          $name
 * @property string          $date_create
 *
 * @property Order[]         $orders
 * @property ProcessSource[] $processSources
 * @property SourceSystem[]  $sourceSystems
 */
class Source extends ActiveRecord
{
    const DEFAULT_SOURCE = 1;
    const SOURCE_OPERATOR = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
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
            'name'        => 'Название',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessSources()
    {
        return $this->hasMany(ProcessSource::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceSystems()
    {
        return $this->hasMany(SourceSystem::className(), ['source_id' => 'id']);
    }
}
