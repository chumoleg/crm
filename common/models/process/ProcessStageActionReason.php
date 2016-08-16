<?php

namespace common\models\process;

use common\components\base\ActiveRecord;
use common\models\reason\Reason;

/**
 * This is the model class for table "process_stage_action_reason".
 *
 * @property integer            $id
 * @property integer            $process_stage_action_id
 * @property integer            $reason_id
 * @property string             $date_create
 *
 * @property ProcessStageAction $processStageAction
 * @property Reason             $reason
 */
class ProcessStageActionReason extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_stage_action_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_stage_action_id', 'reason_id'], 'required'],
            [['process_stage_action_id', 'reason_id'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                      => 'ID',
            'process_stage_action_id' => 'Process Stage Action ID',
            'reason_id'               => 'Reason ID',
            'date_create'             => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStageAction()
    {
        return $this->hasOne(ProcessStageAction::className(), ['id' => 'process_stage_action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(Reason::className(), ['id' => 'reason_id']);
    }
}
