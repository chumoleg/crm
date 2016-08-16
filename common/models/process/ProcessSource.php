<?php

namespace common\models\process;

use common\models\order\Order;
use Yii;
use common\components\base\ActiveRecord;
use common\models\source\Source;
use common\components\helpers\ArrayHelper;

/**
 * This is the model class for table "process_source".
 *
 * @property integer $id
 * @property integer $process_id
 * @property integer $source_id
 * @property string  $date_create
 *
 * @property Process $process
 * @property Source  $source
 */
class ProcessSource extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'source_id'], 'required'],
            [['process_id', 'source_id'], 'integer'],
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
            'source_id'   => 'Source ID',
            'date_create' => 'Date Create',
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
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    public static function addNewRow(Process $process, $sourceId)
    {
        $model = new self();
        $model->process_id = $process->id;
        $model->source_id = $sourceId;
        $model->save();
    }
}
