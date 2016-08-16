<?php

namespace common\models\process;

use common\components\Status;
use \common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\order\Order;

/**
 * This is the model class for table "process".
 *
 * @property integer         $id
 * @property integer         $type
 * @property string          $name
 * @property integer         $status
 * @property integer         $user_id
 * @property string          $date_create
 *
 * @property Order[]         $orders
 * @property User            $user
 * @property ProcessSource[] $processSources
 * @property ProcessStage[]  $processStages
 */
class Process extends ActiveRecord
{
    const TYPE_ORDER = 1;

    public static $typeList
        = [
            self::TYPE_ORDER => 'Для заказов'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * @param $sourceId
     *
     * @return null|Process
     */
    public static function findProcessBySource($sourceId)
    {
        return self::find()
            ->joinWith('processSources')
            ->andWhere(['process_source.source_id' => $sourceId])
            ->andWhere(['status' => Status::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['name'], 'unique'],
            [['type', 'status', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'type'        => 'Тип',
            'name'        => 'Название',
            'status'      => 'Статус',
            'user_id'     => 'Создан',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['process_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessSources()
    {
        return $this->hasMany(ProcessSource::className(), ['process_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStages()
    {
        return $this->hasMany(ProcessStage::className(), ['process_id' => 'id']);
    }

    public function getFirstStage()
    {
        return ProcessStage::findFirst($this);
    }
}
