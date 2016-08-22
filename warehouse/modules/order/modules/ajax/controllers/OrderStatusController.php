<?php

namespace warehouse\modules\order\modules\ajax\controllers;

use warehouse\models\transaction\Transaction;
use warehouse\models\transaction\TransactionProductComponent;
use warehouse\modules\stock\forms\TransactionForm;
use Yii;

class OrderStatusController extends \common\components\controllers\order\OrderStatusController
{
    protected function _writeProductComponents()
    {
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
}
