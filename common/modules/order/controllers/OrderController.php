<?php

namespace common\modules\order\controllers;

use common\components\controllers\CrudController;
use common\components\helpers\ArrayHelper;
use common\models\order\Order;
use common\models\order\OrderSearch;
use common\models\process\Process;
use common\forms\CreateOrderForm;

class OrderController extends CrudController
{
    public $indexTitle = 'Список сделок в работе';

    protected function _getSearchClassName()
    {
        return OrderSearch::className();
    }

    protected function _getModelById($id)
    {
        return Order::findById($id);
    }

    protected function _getFormClassName()
    {
        return CreateOrderForm::className();
    }

    public function actionUpdateProcess()
    {
        /** @var Order[] $orders */
        $orders = Order::getOrderWithoutProcess();

        foreach ($orders as $order) {
            if (empty($order->source)) {
                continue;
            }

            $process = Process::findProcessBySource($order->source_id);
            $order->process_id = ArrayHelper::getValue($process, 'id');
            $order->save();

            $order->saveFirstOrderStage();
        }

        return $this->redirect('index');
    }
}
