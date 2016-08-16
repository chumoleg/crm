<?php

namespace common\components\models;

use common\components\helpers\ArrayHelper;
use common\components\Status;
use common\models\order\OrderStage;
use Yii;
use common\models\order\Order;
use common\models\process\ProcessStage;
use common\components\helpers\TypeSearchOperatorHelper;

class OrderSetOperator
{
    /**
     * @var Order
     */
    private $_model;
    private $_possibleOperators;
    /**
     * @var ProcessStage
     */
    private $_processStage;

    public function update($model)
    {
        $this->_model = $model;
        if (empty($this->_model->process_id)) {
            return false;
        }

        $currentStage = $this->_model->currentOrderStage;
        if (empty($currentStage)) {
            return false;
        }

        $this->_processStage = ProcessStage::findByProcessAndStage($this->_model->process, $currentStage->stage);
        if (empty($this->_processStage)) {
            return false;
        }

        $processStageOperators = $this->_processStage->processStageOperators;
        if (empty($processStageOperators)) {
            return false;
        }

        $operators = [];
        $orderTags = ArrayHelper::getColumn($this->_model->getTagsFromProducts(), 'id');
        if (!empty($orderTags)) {
            foreach ($processStageOperators as $processStageOperator) {
                $userTags = ArrayHelper::getColumn($processStageOperator->operator->userTags, 'tag_id');
                foreach ($userTags as $tag) {
                    if (in_array($tag, $orderTags)) {
                        $operators[] = $processStageOperator->operator_id;
                        break;
                    }
                }
            }
        }

        $this->_possibleOperators = $operators;

        $operator = null;
        if (!empty($this->_possibleOperators)) {
            $first = $this->_possibleOperators[0];

            if (count($this->_possibleOperators) == 1) {
                $operator = $first;
            } else {
                $typeSearchOperator = $this->_processStage->type_search_operator;
                if ($typeSearchOperator == TypeSearchOperatorHelper::BY_IF_WORKED) {
                    $operator = $this->_getOperatorByIfWorked();

                } elseif ($typeSearchOperator == TypeSearchOperatorHelper::BY_IN_ORDER) {
                    $operator = $this->_getOperatorByInOrder();

                } else {
                    $operator = $first;
                }
            }
        }

        return $this->_model->updateCurrentOperator($operator);
    }

    private function _getCacheKeyLoadOrders()
    {
        return 'loadOrdersForOperators_' . $this->_processStage->stage_id;
    }

    /**
     * @return int|null
     */
    private function _getOperatorByCachedUsers()
    {
        $cachedUsers = Yii::$app->cache->get($this->_getCacheKeyLoadOrders());
        if (empty($cachedUsers)) {
            $cachedUsers = [];
        }

        $operator = null;
        foreach ($this->_possibleOperators as $userId) {
            if (!in_array($userId, $cachedUsers)) {
                $operator = $userId;
                $cachedUsers[] = $userId;
                Yii::$app->cache->set($this->_getCacheKeyLoadOrders(), $cachedUsers);

                break;
            }
        }

        return $operator;
    }

    /**
     * @return int|mixed|null
     */
    private function _getOperatorByIfWorked()
    {
        $orderStage = OrderStage::find()
            ->andWhere(['IN', 'user_id', $this->_possibleOperators])
            ->andWhere(['order_id' => $this->_model->id])
            ->andWhere(['status' => Status::STATUS_ARCHIVE])
            ->orderBy('id')
            ->one();

        if (!empty($orderStage)) {
            $operator = $orderStage->user_id;
        } else {
            $operator = $this->_getOperatorByInOrder();
        }

        return $operator;
    }

    /**
     * @return int|null
     */
    private function _getOperatorByInOrder()
    {
        $operator = $this->_getOperatorByCachedUsers();
        if (empty($operator)) {
            Yii::$app->cache->set($this->_getCacheKeyLoadOrders(), []);
            $operator = $this->_getOperatorByCachedUsers();
        }

        return $operator;
    }
}
