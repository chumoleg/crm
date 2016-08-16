<?php

namespace common\models\action;

use common\components\base\ActiveRecord;
use common\models\process\ProcessStageAction;

/**
 * This is the model class for table "action".
 *
 * @property integer              $id
 * @property string               $name
 * @property integer              $hold
 * @property string               $date_create
 *
 * @property ProcessStageAction[] $processStageActions
 */
class Action extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'hold'], 'required'],
            [['hold'], 'integer'],
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
            'hold'        => 'Отложен',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStageActions()
    {
        return $this->hasMany(ProcessStageAction::className(), ['action_id' => 'id']);
    }
}
