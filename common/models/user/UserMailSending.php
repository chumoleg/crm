<?php

namespace common\models\user;

use common\components\base\ActiveRecord;

/**
 * This is the model class for table "user_mail_sending".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string  $date_create
 *
 * @property User    $user
 */
class UserMailSending extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_mail_sending';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['date_create'], 'safe'],
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
