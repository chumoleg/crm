<?php

namespace common\models\process;

use common\models\stage\Stage;
use \common\components\base\ActiveRecord;
use common\models\action\Action;

/**
 * This is the model class for table "process_stage_action".
 *
 * @property integer                    $id
 * @property integer                    $process_stage_id
 * @property integer                    $action_id
 * @property integer                    $follow_to_stage_id
 * @property integer                    $user_id
 * @property string                     $date_create
 *
 * @property Stage                      $followToStage
 * @property ProcessStage               $processStage
 * @property Action                     $action
 * @property ProcessStageActionReason[] $processStageActionReasons
 */
class ProcessStageAction extends ActiveRecord
{
    public $reasonData = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_stage_action';
    }

    /**
     * @param ProcessStage $processStage
     * @param Action       $action
     *
     * @return ProcessStageAction|null|array
     */
    public static function findByProcessStageAndAction(ProcessStage $processStage, Action $action)
    {
        return self::find()
            ->andWhere(['process_stage_id' => $processStage->id])
            ->andWhere(['action_id' => $action->id])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_stage_id', 'action_id', 'follow_to_stage_id', 'user_id'], 'integer'],
            [['date_create', 'reasonData'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'process_stage_id'   => 'Process Stage ID',
            'action_id'          => 'Действие',
            'follow_to_stage_id' => 'Следующий статус',
            'user_id'            => 'User ID',
            'date_create'        => 'Date Create',
            'reasonData'         => 'Причины',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowToStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'follow_to_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStage()
    {
        return $this->hasOne(ProcessStage::className(), ['id' => 'process_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStageActionReasons()
    {
        return $this->hasMany(ProcessStageActionReason::className(), ['process_stage_action_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveReasonData();
        parent::afterSave($insert, $changedAttributes);
    }

    private function _saveReasonData()
    {
        ProcessStageActionReason::deleteAll(['process_stage_action_id' => $this->id]);
        if (empty($this->reasonData)) {
            return;
        }

        foreach ($this->reasonData as $reasonId) {
            $model = new ProcessStageActionReason();
            $model->process_stage_action_id = $this->id;
            $model->reason_id = $reasonId;
            $model->save();
        }
    }
}
