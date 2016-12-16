<?php

namespace common\models\order;

use Yii;
use common\models\company\Company;
use common\models\transaction\Transaction;
use common\models\process\ProcessStage;
use common\models\stage\StageMethod;
use common\components\Status;
use common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\process\Process;
use common\models\source\Source;
use common\components\models\OrderSetOperator;
use common\models\product\ProductTag;
use common\models\tag\Tag;
use common\models\stage\Stage;
use common\components\Role;

/**
 * This is the model class for table "order".
 *
 * @property integer            $id
 * @property integer            $source_id
 * @property integer            $company_id
 * @property integer            $process_id
 * @property integer            $current_stage_id
 * @property string             $price
 * @property integer            $currency
 * @property integer            $current_user_id
 * @property string             $time_postponed
 * @property integer            $create_user_id
 * @property string             $date_create
 * @property string             $date_update
 *
 * @property Source             $source
 * @property Company            $company
 * @property User               $createUser
 * @property User               $currentUser
 * @property Process            $process
 * @property OrderCallHistory[] $orderCallHistories
 * @property OrderComment[]     $orderComments
 * @property OrderProduct[]     $orderProducts
 * @property OrderStage[]       $orderStages
 * @property OrderStage         $currentOrderStage
 * @property Stage              $currentStage
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @param bool $check
     *
     * @return array|bool|Order[]
     */
    public static function getOrderWithoutProcess($check = false)
    {
        $query = self::find()
            ->andWhere(
                [
                    'OR',
                    'process_id IS NULL',
                    'id NOT IN (SELECT order_id FROM order_stage)',
                ]
            );

        if ($check) {
            return $query->exists();
        }

        return $query->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'company_id',
                    'source_id',
                    'process_id',
                    'current_stage_id',
                    'currency',
                    'current_user_id',
                    'create_user_id',
                ],
                'integer',
            ],
            [['price'], 'number'],
            [['time_postponed', 'date_create', 'date_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'source_id'        => 'Источник',
            'company_id'       => 'Организация',
            'process_id'       => 'Процесс',
            'current_stage_id' => 'Текущий статус',
            'price'            => 'Общая стоимость',
            'currency'         => 'Валюта',
            'current_user_id'  => 'Текущий оператор',
            'time_postponed'   => 'Отложен до',
            'create_user_id'   => 'Создан оператором',
            'date_create'      => 'Дата создания',
            'date_update'      => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentUser()
    {
        return $this->hasOne(User::className(), ['id' => 'current_user_id']);
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
    public function getOrderCallHistories()
    {
        return $this->hasMany(OrderCallHistory::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderComments()
    {
        return $this->hasMany(OrderComment::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStages()
    {
        return $this->hasMany(OrderStage::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentOrderStage()
    {
        return $this->hasOne(OrderStage::className(), ['order_id' => 'id'])
            ->andOnCondition(['order_stage.status' => Status::STATUS_ACTIVE]);
    }

    public function getCurrentStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'current_stage_id']);
    }

    public function updateCurrentStage($stageId)
    {
        $this->current_stage_id = $stageId;
        if (!$this->getIsNewRecord()) {
            self::updateAll(['current_stage_id' => $stageId], 'id = ' . $this->id);
        }
    }

    /**
     * @return bool
     */
    public function recalculatePrice()
    {
        $sum = 0;
        foreach ($this->orderProducts as $orderProduct) {
            $sum += $orderProduct->price * $orderProduct->quantity;
        }

        $this->price = $sum;

        return $this->save();
    }

    public function setOrderOperator()
    {
        return (new OrderSetOperator())->update($this);
    }

    public function updateCurrentOperator($operator)
    {
        if (empty($operator)) {
            $operator = null;
        }

        $oldOperator = $this->current_user_id;
        $this->current_user_id = $operator;

        $textComment = OrderComment::getTextCommentByField('current_user_id', $oldOperator, $operator);
        OrderComment::addCommentToOrder($this->id, $textComment);

        return self::updateAll(['current_user_id' => $operator], 'id = ' . $this->id);
    }

    public function checkAccessManageOrder()
    {
        $currentOrderStage = $this->currentOrderStage;
        $checker = !Yii::$app->user->can(Role::OPERATOR)
            || (Yii::$app->user->can(Role::OPERATOR) && Yii::$app->user->id == $this->current_user_id)
            && (empty($currentOrderStage) || $currentOrderStage->time_limit != 0);

        return $checker;
    }

    public function saveFirstOrderStage()
    {
        if (empty($this->process_id)) {
            return;
        }

        $process = Process::findById($this->process_id);
        if (empty($process) || empty($process->processStages)) {
            return;
        }

        $firstProcessStage = $process->getFirstStage();
        if (!empty($firstProcessStage)) {
            OrderStage::addStageRow($this, $firstProcessStage);
        }
    }

    /**
     * @return array
     */
    public function getTagsFromProducts()
    {
        $orderProductQuery = $this->getOrderProducts()->select(['product_id']);
        $innerQuery = ProductTag::find()->select(['tag_id'])->andWhere(['IN', 'product_id', $orderProductQuery]);

        return Tag::find()->andWhere(['IN', 'id', $innerQuery])->all();
    }

    /**
     * @return ProcessStage|array|null
     */
    public function getProcessStage()
    {
        return ProcessStage::find()
            ->andWhere(['process_id' => $this->process_id])
            ->andWhere(['stage_id' => $this->current_stage_id])
            ->one();
    }

    public function accessCalling()
    {
        if (empty($this->currentStage)) {
            return false;
        }

        return $this->currentStage->existStageMethod(StageMethod::METHOD_CALL);
    }

    public function accessWarehouseTransactionWritten()
    {
        if (empty($this->currentStage)) {
            return false;
        }

        return $this->currentStage->existStageMethod(StageMethod::METHOD_WRITE_PRODUCT_COMPONENTS);
    }

    public function accessWarehouseTransactionReturn()
    {
        if (empty($this->currentStage)) {
            return false;
        }

        return $this->currentStage->existStageMethod(StageMethod::METHOD_RETURN_PRODUCT_COMPONENTS);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTransactions()
    {
        return $this->hasMany(OrderTransaction::className(), ['order_id' => 'id']);
    }

    /**
     * @return array|null|OrderTransaction
     */
    public function getWrittenOrderTransaction()
    {
        return $this
            ->getOrderTransactions()
            ->joinWith(
                [
                    'transaction' => function ($q) {
                        $q->andWhere(['type' => Transaction::TYPE_WRITTEN]);
                    },
                ]
            )
            ->one();
    }

    /**
     * @return array|null|OrderTransaction
     */
    public function getReturnOrderTransaction()
    {
        return $this
            ->getOrderTransactions()
            ->joinWith(
                [
                    'transaction' => function ($q) {
                        $q->andWhere(['type' => Transaction::TYPE_INCOME]);
                    },
                ]
            )
            ->one();
    }
}
