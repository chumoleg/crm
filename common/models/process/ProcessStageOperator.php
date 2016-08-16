<?php

namespace common\models\process;

use common\models\stage\Stage;
use \yii\db\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "process_stage_operator".
 *
 * @property integer $id
 * @property integer $process_id
 * @property integer $stage_id
 * @property integer $operator_id
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property User    $operator
 * @property Process $process
 * @property Stage   $stage
 * @property User    $user
 */
class ProcessStageOperator extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_stage_operator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'stage_id', 'operator_id'], 'required'],
            [['process_id', 'stage_id', 'operator_id', 'user_id'], 'integer'],
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
            'process_id'  => 'Process ID',
            'stage_id'    => 'Stage ID',
            'operator_id' => 'Operator ID',
            'user_id'     => 'User ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator()
    {
        return $this->hasOne(User::className(), ['id' => 'operator_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
