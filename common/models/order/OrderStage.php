<?php

namespace common\models\order;

use common\models\action\Action;
use common\models\reason\Reason;
use Yii;
use common\components\base\ActiveRecord;
use common\components\Status;
use common\models\stage\Stage;
use common\components\helpers\TimeHelper;
use common\models\process\ProcessStage;
use yii\log\Logger;

/**
 * This is the model class for table "order_stage".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $stage_id
 * @property integer $action_id
 * @property integer $reason_id
 * @property integer $status
 * @property integer $overdue
 * @property integer $time_limit
 * @property integer $time_spent
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property Order   $order
 * @property Stage   $stage
 * @property Action  $action
 * @property Reason  $reason
 */
class OrderStage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_stage';
    }

    /**
     * @param Order        $order
     * @param ProcessStage $processStage
     *
     * @return bool
     */
    public static function addStageRow(Order $order, ProcessStage $processStage)
    {
        $model = new self();
        $model->order_id = $order->id;
        $model->stage_id = $processStage->stage->id;
        $model->time_limit = TimeHelper::getInSecond($processStage->time_limit, $processStage->time_unit);
        $model->status = Status::STATUS_ACTIVE;

        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'stage_id'], 'required'],
            [
                [
                    'order_id',
                    'stage_id',
                    'action_id',
                    'reason_id',
                    'status',
                    'user_id',
                    'time_spent',
                    'time_limit',
                    'overdue'
                ],
                'integer'
            ],
            [['date_create', 'time_spent'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'order_id'    => 'Order ID',
            'stage_id'    => 'Stage ID',
            'action_id'   => 'Действие',
            'reason_id'   => 'Причина',
            'status'      => 'Status',
            'overdue'     => 'Просрочено',
            'time_limit'  => 'Время на обработку',
            'time_spent'  => 'Затраченное время',
            'user_id'     => 'User ID',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
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
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(Reason::className(), ['id' => 'reason_id']);
    }

    /**
     * @return bool
     */
    public function setDisabled()
    {
        $this->setTimeSpent();
        $this->user_id = Yii::$app->user->id;

        return $this->setStatus(Status::STATUS_ARCHIVE);
    }

    /**
     * @return ProcessStage|array|null
     */
    public function getProcessStage()
    {
        return ProcessStage::find()
            ->andWhere(['process_id' => $this->order->process_id])
            ->andWhere(['stage_id' => $this->stage_id])
            ->one();
    }

    public function setTimeSpent()
    {
        if ($this->time_limit == 0) {
            return;
        }

        $this->time_spent = time() - strtotime($this->date_create);
        if ($this->time_spent > $this->time_limit) {
            $this->overdue = Status::STATUS_ACTIVE;
        } else {
            $this->overdue = Status::STATUS_NOT_ACTIVE;
        }
    }
}
