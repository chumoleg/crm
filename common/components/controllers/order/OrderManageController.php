<?php

namespace common\components\controllers\order;

use Yii;
use common\components\controllers\BaseController;
use common\models\order\Order;
use common\models\order\OrderComment;
use common\components\helpers\JsonHelper;

class OrderManageController extends BaseController
{
    /**
     * @var Order
     */
    public $model;

    public function init()
    {
        parent::init();

        $orderId = (int)Yii::$app->request->post('orderId');
        $this->model = Order::findById($orderId);
        if (empty($this->model)) {
            JsonHelper::answerError('Заказ не найден!');
        }
    }

    /**
     * @param string $text
     * @param bool   $manually
     *
     * @return string
     */
    protected function _addOrderComment($text, $manually = false)
    {
        $orderComment = OrderComment::addCommentToOrder($this->model->id, $text, $manually);
        if (empty($orderComment->id)) {
            return JsonHelper::answerError('Не удалось сохранить комментарий!');
        }

        return $this->renderPartial('/order-manage/commentList', [
            'commentsList' => $this->model->getOrderComments()->all(),
        ]);
    }

    protected function _checkAccess()
    {
        if (!$this->model->checkAccessManageOrder()) {
            return JsonHelper::answerError('Статус заказа уже изменен! Пожалуйста, обновите страницу.');
        }
    }
}
