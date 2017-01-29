<?php

namespace common\models\source;

use common\components\helpers\ArrayHelper;
use common\components\Status;
use common\models\user\User;
use common\models\user\UserSource;
use Yii;
use common\components\base\ActiveRecord;
use common\models\order\Order;
use common\models\process\ProcessSource;

/**
 * This is the model class for table "source".
 *
 * @property integer         $id
 * @property string          $name
 * @property integer         $is_default
 * @property string          $date_create
 *
 * @property Order[]         $orders
 * @property ProcessSource[] $processSources
 * @property SourceSystem[]  $sourceSystems
 */
class Source extends ActiveRecord
{
    const DEFAULT_SOURCE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['date_create', 'is_default'], 'safe'],
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
            'is_default'  => 'По умолчанию',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    private static function _getQueryForList()
    {
        $query = self::find();
        if (!empty(Yii::$app->user->id) && !User::isAdmin()) {
            $query->andWhere('id IN (SELECT source_id FROM ' . UserSource::tableName()
                . ' WHERE user_id = ' . Yii::$app->user->id . ')');
        }

        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessSources()
    {
        return $this->hasMany(ProcessSource::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceSystems()
    {
        return $this->hasMany(SourceSystem::className(), ['source_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $data = self::_getQueryForList()->all();

        return ArrayHelper::map($data, 'id', 'name');
    }

    /**
     * @return self|null
     */
    public function getDefaultSource()
    {
        return self::_getQueryForList()->andWhere(['is_default' => Status::STATUS_ACTIVE])->one();
    }
}
