<?php

namespace common\modules\order\modules\ajax\controllers;

use Yii;
use yii\base\Exception;
use common\models\company\CompanyContact;
use common\models\order\Order;
use common\components\asterisk\Asterisk;
use common\models\order\OrderComment;
use common\components\helpers\JsonHelper;
use common\components\controllers\order\OrderManageController;

class OrderController extends OrderManageController
{
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
        $contactId = (int)Yii::$app->request->post('contactId');
        if (empty($contactId)) {
            return JsonHelper::answerError('Выбран некорректный контакт');
        }

        $companyContact = CompanyContact::findById($contactId);

        try {
            $workPlace = Yii::$app->user->getWorkPlace();
            if (empty($workPlace)) {
                throw new Exception('Не выставлен № компьютера');
            }

            Asterisk::getModel()->call($workPlace, $companyContact->value, $this->model->id);
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

    public function actionContactForm($id)
    {
        $order = Order::findById($id);

        $model = new CompanyContact();
        $model->company_id = $order->company_customer;

        return $this->renderAjax('contactForm', ['model' => $model]);
    }

    public function actionAddCompanyContact()
    {
        $formData = Yii::$app->request->post('formData');
        parse_str($formData, $params);

        $model = new CompanyContact();
        $model->load($params);
        $model->save();

        $attributes = [
            'Коммент: ' . $model->person,
            CompanyContact::$typeList[$model->type] . ': ' . $model->value
        ];

        $commentText = 'Добавлен контакт: ' . implode('; ', $attributes);

        return JsonHelper::answerSuccess([
            'commentList' => $this->_addOrderComment($commentText)
        ]);
    }
}
