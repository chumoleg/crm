<?php

namespace common\models;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\order\OrderComment;

/**
 * This is the model class for table "comment".
 *
 * @property integer        $id
 * @property string         $text
 * @property string         $comment_hash
 * @property integer        $user_id
 * @property string         $date_create
 *
 * @property User           $user
 * @property OrderComment[] $orderComments
 */
class Comment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @param string $text
     *
     * @return int
     */
    public static function getIdByText($text)
    {
        if (empty($text)) {
            return null;
        }

        $hash = md5($text);
        $model = self::find()->andWhere(['comment_hash' => $hash])->one();
        if (empty($model)) {
            $model = new self();
            $model->text = $text;
            $model->comment_hash = $hash;
            $model->save();
        }

        return $model->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_hash', 'text'], 'required'],
            [['text'], 'string'],
            [['user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['comment_hash'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'text'         => 'Text',
            'comment_hash' => 'Comment Hash',
            'user_id'      => 'User ID',
            'date_create'  => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderComments()
    {
        return $this->hasMany(OrderComment::className(), ['comment_id' => 'id']);
    }
}
