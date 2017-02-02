<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\helpers\ArrayHelper;
use common\components\MailSending;
use common\models\order\Order;
use common\models\user\User;

class MailController extends Controller
{
    private $_subject;

    /**
     * @var User[] $users
     */
    private $_users;

    public function actionSendOrdersOnToday()
    {
        $this->_setAttributes(MailSending::ORDERS_ON_TODAY);
        if (empty($this->_users)) {
            return;
        }

        $date = date('Y-m-d');
        foreach ($this->_users as $user) {
            $companyIds = ArrayHelper::getColumn($user->userCompanies, 'id');

            $orders = Order::find()
                ->andWhere('time_postponed <= "' . $date . '"')
                ->andWhere(['IN', 'company_customer', $companyIds])
                ->asArray()
                ->all();

            if (empty($orders)) {
                continue;
            }

            $mailView = ['html' => 'order/postponedOnToday'];
            $viewParams = ['orderData' => $orders];

            Yii::$app->mailer->compose($mailView, $viewParams)
                ->setFrom('no-reply@crm2.sttk.tv')
                ->setTo($user->email)
                ->setSubject($this->_subject)
                ->send();

            Yii::$app->mailer->compose($mailView, $viewParams)
                ->setFrom('no-reply@crm2.sttk.tv')
                ->setTo('chumoleg@yandex.ru')
                ->setSubject($this->_subject)
                ->send();
        }
    }

    public function actionSendOverdueOrdersOnToday()
    {
        $this->_setAttributes(MailSending::OVERDUE_ON_TODAY);
        if (empty($this->_users)) {
            return;
        }

        $date = date('Y-m-d');
        $orders = Order::find()
            ->andWhere('time_postponed < "' . $date . '"')
            ->joinWith(['companyCustomer.currentOperator'])
            ->asArray()
            ->all();

        if (empty($orders)) {
            return;
        }

        $mailView = ['html' => 'order/overdueOnToday'];
        $viewParams = ['orderData' => $orders];

        foreach ($this->_users as $user) {
            Yii::$app->mailer->compose($mailView, $viewParams)
                ->setFrom('no-reply@crm2.sttk.tv')
                ->setTo($user->email)
                ->setSubject($this->_subject)
                ->send();
        }

        Yii::$app->mailer->compose($mailView, $viewParams)
            ->setFrom('no-reply@crm2.sttk.tv')
            ->setTo('chumoleg@yandex.ru')
            ->setSubject($this->_subject)
            ->send();
    }

    private function _setAttributes($sendingType)
    {
        $this->_subject = MailSending::$typeList[$sendingType];

        $this->_users = User::find()
            ->joinWith([
                'userMailSending' => function ($q) use ($sendingType) {
                    $q->andWhere(['type' => $sendingType]);
                },
            ])
            ->all();
    }
}