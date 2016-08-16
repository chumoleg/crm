<?php

namespace common\models\user;

use Yii;
use \common\components\base\ActiveRecord;

/**
 * This is the model class for table "user_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $action
 * @property integer $comment
 * @property string  $date_create
 *
 * @property User    $user
 */
class UserHistory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action', 'comment'], 'required'],
            [['user_id', 'action', 'comment'], 'integer'],
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
            'user_id'     => 'User ID',
            'action'      => 'Action',
            'comment'     => 'Comment',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
