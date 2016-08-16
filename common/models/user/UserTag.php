<?php

namespace common\models\user;

use common\components\base\ActiveRecord;
use common\models\tag\Tag;;

/**
 * This is the model class for table "user_tag".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tag_id
 * @property string  $date_create
 *
 * @property Tag     $tag
 * @property User    $user
 */
class UserTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tag_id'], 'required'],
            [['user_id', 'tag_id'], 'integer'],
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
            'tag_id'      => 'Tag ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
