<?php

namespace common\models\system;

use common\components\base\ActiveRecord;
use common\models\stage\Stage;

/**
 * This is the model class for table "system_stage".
 *
 * @property integer $id
 * @property integer $system_id
 * @property integer $stage_id
 * @property string  $foreign_status
 * @property string  $date_create
 *
 * @property Stage   $stage
 * @property System  $system
 */
class SystemStage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_stage';
    }

    public static function getModelBySystemAndStage($systemId, $stageId)
    {
        $model = self::find()
            ->andWhere(['system_id' => $systemId])
            ->andWhere(['stage_id' => $stageId])
            ->one();

        if (empty($model)) {
            $model = new self();
            $model->system_id = $systemId;
            $model->stage_id = $stageId;
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['foreign_status'], 'filter', 'filter' => 'trim'],
            [['system_id', 'stage_id', 'foreign_status'], 'required'],
            [['system_id', 'stage_id'], 'integer'],
            [['date_create'], 'safe'],
            [['foreign_status'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'system_id'      => 'System ID',
            'stage_id'       => 'Stage ID',
            'foreign_status' => 'Внешнее значение',
            'date_create'    => 'Date Create',
        ];
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
    public function getSystem()
    {
        return $this->hasOne(System::className(), ['id' => 'system_id']);
    }
}
