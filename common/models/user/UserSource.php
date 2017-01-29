<?php

namespace common\models\user;

use Yii;
use common\models\source\Source;

/**
 * This is the model class for table "user_source".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $source_id
 *
 * @property Source  $source
 * @property User    $user
 */
class UserSource extends \common\components\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source_id'], 'required'],
            [['user_id', 'source_id'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
