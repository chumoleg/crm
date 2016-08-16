<?php

namespace common\models\system;

use common\components\base\ActiveRecord;

/**
 * This is the model class for table "system".
 *
 * @property integer         $id
 * @property string          $name
 * @property string          $date_create
 *
 * @property SystemProduct[] $systemProducts
 * @property SystemStage[]   $systemStages
 * @property SystemUrl[]     $systemUrls
 */
class System extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 200]
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
    public function getSystemProducts()
    {
        return $this->hasMany(SystemProduct::className(), ['system_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemStages()
    {
        return $this->hasMany(SystemStage::className(), ['system_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemUrls()
    {
        return $this->hasMany(SystemUrl::className(), ['system_id' => 'id']);
    }

    /**
     * @param $type
     *
     * @return array|null|SystemUrl
     */
    public function getSystemUrlByType($type)
    {
        return $this
            ->getSystemUrls()
            ->andWhere(['system_url.type' => $type])
            ->one();
    }

    /**
     * @param $stageId
     *
     * @return array|null|SystemStage
     */
    public function getSystemStageByStage($stageId)
    {
        return $this
            ->getSystemStages()
            ->andWhere(['system_stage.stage_id' => $stageId])
            ->one();
    }
}
