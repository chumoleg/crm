<?php

namespace common\models\source;

use common\components\base\ActiveRecord;
use common\models\system\System;

/**
 * This is the model class for table "source_system".
 *
 * @property integer $id
 * @property integer $source_id
 * @property integer $system_id
 * @property string  $date_create
 *
 * @property Source  $source
 * @property System  $system
 */
class SourceSystem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'system_id'], 'required'],
            [['source_id', 'system_id'], 'integer'],
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
            'source_id'   => 'Source ID',
            'system_id'   => 'System ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(System::className(), ['id' => 'system_id']);
    }
}
