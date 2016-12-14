<?php

namespace common\modules\order\modules\ajax\controllers;

use Yii;
use common\components\asterisk\Asterisk;
use common\models\order\OrderComment;
use common\components\helpers\JsonHelper;
use yii\base\Exception;
use common\components\controllers\order\OrderManageController;

class OrderController extends OrderManageController
{
    public function actionSetCurrentOperator()
    {
        $operator = Yii::$app->request->post('operator');
        if (!$this->model->updateCurrentOperator($operator)) {
            return JsonHelper::answerError('Ошибка при смене оператора!');
        }

        return JsonHelper::answerSuccess(true);
    }

    public function actionAddComment()
    {
        $text = Yii::$app->request->post('text');
        $commentList = $this->_addOrderComment($text, true);

        return JsonHelper::answerSuccess($commentList);
    }

    public function actionUpdate()
    {
        $this->_checkAccess();

        $fieldName = Yii::$app->request->post('fieldName');
        $value = Yii::$app->request->post('value');

        if (in_array($fieldName, $this->model->attributes())) {
            $oldValue = $this->model->{$fieldName};
            $this->model->{$fieldName} = $value;
            $this->model->save();

        } else {
            return JsonHelper::answerSuccess();
        }

        $textComment = OrderComment::getTextCommentByField($fieldName, $oldValue, $value);
        $commentList = $this->_addOrderComment($textComment);

        return JsonHelper::answerSuccess($commentList);
    }

    public function actionCall()
    {
        $this->_checkAccess();

        try {
            $workPlace = Yii::$app->getUser()->getWorkPlace();
            if (empty($workPlace)) {
                throw new Exception('Не выставлен № компьютера');
            }

            Asterisk::getModel()->call($workPlace, $this->model->client->getPhone(), $this->model->id);
            $commentList = $this->_addOrderComment('Совершен звонок');

            return JsonHelper::answerSuccess($commentList);

        } catch (Exception $e) {
            return JsonHelper::answerError('Ошибка при попытке позвонить! ' . $e->getMessage());
        }
    }

    public function actionSendSms()
    {
        $this->_checkAccess();

        $commentList = $this->_addOrderComment('Отправлено sms-сообщение');

        return JsonHelper::answerSuccess($commentList);
    }
}
