<?php

namespace common\models\order;

use common\components\helpers\ArrayHelper;
use common\components\nomenclature\TypePayment;
use common\models\geo\GeoAddress;
use common\models\geo\GeoArea;
use \common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\Comment;

/**
 * This is the model class for table "order_comment".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $comment_id
 * @property integer $user_id
 * @property integer $manually
 * @property string  $date_create
 *
 * @property Comment $comment
 * @property Order   $order
 * @property User    $user
 */
class OrderComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_comment';
    }

    /**
     * @param int    $orderId
     * @param string $commentText
     * @param bool   $manually
     *
     * @return OrderComment
     */
    public static function addCommentToOrder($orderId, $commentText, $manually = false)
    {
        $commentId = Comment::getIdByText($commentText);

        $model = new self();
        $model->order_id = (int)$orderId;
        $model->comment_id = $commentId;
        $model->manually = (int)$manually;
        $model->save();

        return self::findById($model->id);
    }

    /**
     * @param $fieldName
     * @param $oldValue
     * @param $newValue
     *
     * @return string
     */
    public static function getTextCommentByField($fieldName, $oldValue, $newValue)
    {
        $order = new Order();
        $geoAddress = new GeoAddress();
        $fields = ArrayHelper::merge(
            $geoAddress->attributeLabels(),
            $order->attributeLabels(),
            [
                'fio'             => 'ФИО',
                'phone'           => 'Телефон',
                'current_user_id' => 'Текущий оператор'
            ]);

        if ($fieldName == 'type_payment') {
            $oldValue = TypePayment::getValue($oldValue);
            $newValue = TypePayment::getValue($newValue);

        } elseif ($fieldName == 'area_id') {
            $oldValue = GeoArea::getName(GeoArea::findById($oldValue));
            $newValue = GeoArea::getName(GeoArea::findById($newValue));

        } elseif ($fieldName == 'current_user_id') {
            $oldValue = ArrayHelper::getValue(User::findById($oldValue), 'fio');
            $newValue = ArrayHelper::getValue(User::findById($newValue), 'fio');
        }

        if (empty($oldValue)) {
            $oldValue = '""';
        }

        if (empty($newValue)) {
            $newValue = '""';
        }

        if ($oldValue == $newValue) {
            return '';
        }

        return '"' . ArrayHelper::getValue($fields, $fieldName) . '": ' . $oldValue . ' → ' . $newValue . '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'comment_id'], 'required'],
            [['order_id', 'comment_id', 'user_id', 'manually'], 'integer'],
            [['date_create'], 'safe'],
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
            'comment_id'  => 'Comment ID',
            'user_id'     => 'User ID',
            'manually'    => 'Manually',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
