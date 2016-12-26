<?php

namespace common\models\process;

use common\components\Status;
use \common\components\base\ActiveRecord;
use common\models\stage\Stage;

/**
 * This is the model class for table "process_stage".
 *
 * @property integer                $id
 * @property integer                $process_id
 * @property integer                $stage_id
 * @property integer                $first_stage
 * @property integer                $time_limit
 * @property integer                $time_unit
 * @property integer                $type_search_operator
 * @property integer                $user_id
 * @property string                 $date_create
 *
 * @property Process                $process
 * @property Stage                  $stage
 * @property ProcessStageAction[]   $actions
 */
class ProcessStage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_stage';
    }

    /**
     * @param Process $process
     * @param Stage   $stage
     *
     * @return array|null|ProcessStage
     */
    public static function findByProcessAndStage(Process $process, Stage $stage)
    {
        return self::find()
            ->andWhere(['process_id' => $process->id])
            ->andWhere(['stage_id' => $stage->id])
            ->one();
    }

    /**
     * @param Process $process
     *
     * @return array|null|ProcessStage
     */
    public static function findFirst(Process $process)
    {
        return self::find()
            ->andWhere(['process_id' => $process->id])
            ->andWhere(['first_stage' => Status::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stage_id', 'time_limit', 'time_unit'], 'required'],
            [
                ['process_id', 'stage_id', 'time_limit', 'time_unit', 'user_id', 'first_stage', 'type_search_operator'],
                'integer'
            ],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'process_id'           => 'Process ID',
            'stage_id'             => 'Статус',
            'time_limit'           => 'Время обработки',
            'time_unit'            => 'Ед.изм времени',
            'type_search_operator' => 'Тип выбора оператора',
            'first_stage'          => 'Начальный статус',
            'user_id'              => 'User ID',
            'date_create'          => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(Process::className(), ['id' => 'process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(ProcessStageAction::className(), ['process_stage_id' => 'id']);
    }
}
