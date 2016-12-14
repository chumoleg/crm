<?php

namespace common\modules\order\modules\ajax\controllers;

use common\models\order\Order;
use common\models\transaction\Transaction;
use common\models\transaction\TransactionProductComponent;
use warehouse\modules\stock\forms\TransactionForm;

class OrderStatusController extends \common\components\controllers\order\OrderStatusController
{
    /**
     * @var Order
     */
    public $model;

    protected function _additionalOperationsForModule()
    {
        if ($this->model->accessWarehouseTransactionWritten()) {
            $this->_writeProductComponents();
        }

        if ($this->model->accessWarehouseTransactionReturn()) {
            $this->_returnProductComponents();
        }
    }

    protected function _writeProductComponents()
    {
        $writtenOrderTransaction = $this->model->getWrittenOrderTransaction();
        $returnOrderTransaction = $this->model->getReturnOrderTransaction();
        if (!empty($writtenOrderTransaction) && empty($returnOrderTransaction)) {
            return;
        }

        $productComponents = [];
        foreach ($this->model->orderProducts as $orderProduct) {
            $productTechList = $orderProduct->product->productTechList;
            if (empty($productTechList)) {
                continue;
            }

            $techListProductComponents = $productTechList->techList->techListProductComponents;
            if (empty($techListProductComponents)) {
                continue;
            }

            foreach ($techListProductComponents as $techListProductComponent) {
                $productComponentId = $techListProductComponent->product_component_id;
                $quantity = $techListProductComponent->quantity * $orderProduct->quantity;
                if (isset($productComponents[$productComponentId])) {
                    $productComponents[$productComponentId] += $quantity;
                } else {
                    $productComponents[$productComponentId] = $quantity;
                }
            }
        }

        $transactionProductComponents = [];
        foreach ($productComponents as $productComponentId => $quantity) {
            $model = new TransactionProductComponent();
            $model->product_component_id = $productComponentId;
            $model->quantity = $quantity;

            $transactionProductComponents[] = $model;
        }

        $form = new TransactionForm();
        $form->name = 'Списание комплектующих по заявке №' . $this->model->id;
        $form->type = Transaction::TYPE_WRITTEN;
        $form->transactionProductComponents = $transactionProductComponents;
        $form->saveCreateForm();
    }

    protected function _returnProductComponents()
    {
        $writtenOrderTransaction = $this->model->getWrittenOrderTransaction();
        $returnOrderTransaction = $this->model->getReturnOrderTransaction();
        if (empty($writtenOrderTransaction) || !empty($returnOrderTransaction)) {
            return;
        }

        $form = new TransactionForm();
        $form->name = 'Возврат комплектующих по заявке №' . $this->model->id;
        $form->type = Transaction::TYPE_INCOME;
        $form->transactionProductComponents = $writtenOrderTransaction->transaction->transactionProductComponents;
        $form->saveCreateForm();
    }
}