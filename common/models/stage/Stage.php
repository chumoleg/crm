<?php

namespace common\models\stage;

use common\components\base\ActiveRecord;
use common\models\process\ProcessStage;

/**
 * This is the model class for table "stage".
 *
 * @property integer        $id
 * @property integer        $department
 * @property string         $name
 * @property string         $alias
 * @property integer        $user_id
 * @property string         $date_create
 *
 * @property ProcessStage[] $processStages
 * @property StageMethod[]  $stageMethods
 */
class Stage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias', 'department'], 'required'],
            [['user_id', 'department'], 'integer'],
            [['date_create'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'department'  => 'Отделение',
            'name'        => 'Название',
            'alias'       => 'Алиас',
            'user_id'     => 'User ID',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStages()
    {
        return $this->hasMany(ProcessStage::className(), ['stage_id' => 'id']);
    }

    /**
     * @param $alias
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByAlias($alias)
    {
        if (empty($alias)) {
            return null;
        }

        return self::find()->andWhere(['alias' => $alias])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStageMethods()
    {
        return $this->hasMany(StageMethod::className(), ['stage_id' => 'id']);
    }

    public function existStageMethod($method)
    {
        return $this
            ->getStageMethods()
            ->andWhere(['method' => $method])
            ->exists();
    }
}
