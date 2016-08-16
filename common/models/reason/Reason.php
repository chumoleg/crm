<?php

namespace common\models\reason;

use common\components\base\ActiveRecord;
use common\models\process\ProcessStageActionReason;

/**
 * This is the model class for table "reason".
 *
 * @property integer                    $id
 * @property string                     $name
 * @property string                     $date_create
 *
 * @property ProcessStageActionReason[] $actionReasons
 */
class Reason extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 100]
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
    public function getProcessStageActionReasons()
    {
        return $this->hasMany(ProcessStageActionReason::className(), ['reason_id' => 'id']);
    }
}
