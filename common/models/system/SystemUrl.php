<?php

namespace common\models\system;

use common\components\base\ActiveRecord;

/**
 * This is the model class for table "system_url".
 *
 * @property integer $id
 * @property integer $system_id
 * @property integer $type
 * @property string  $url
 * @property string  $date_create
 *
 * @property System  $system
 */
class SystemUrl extends ActiveRecord
{
    const TYPE_UPDATE_STATUS = 1;

    public static $typeList
        = [
            self::TYPE_UPDATE_STATUS => 'Для обновления статусов'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_url';
    }

    public static function getModelBySystemAndType($systemId, $type)
    {
        $model = self::find()
            ->andWhere(['system_id' => $systemId])
            ->andWhere(['type' => $type])
            ->one();

        if (empty($model)) {
            $model = new self();
            $model->system_id = $systemId;
            $model->type = $type;
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'url'], 'filter', 'filter' => 'trim'],
            [['system_id', 'type', 'url'], 'required'],
            [['system_id', 'type'], 'integer'],
            [['date_create'], 'safe'],
            [['url'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'system_id'   => 'System ID',
            'type'        => 'Type',
            'url'         => 'Url',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(System::className(), ['id' => 'system_id']);
    }
}
