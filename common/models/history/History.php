<?php

namespace common\models\history;

use common\components\base\ActiveRecord;
use common\models\user\User;
use yii\helpers\Json;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $type
 * @property string  $model
 * @property string  $data
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property User    $user
 */
class History extends ActiveRecord
{
    const TYPE_CREATE = 1;
    const TYPE_UPDATE = 2;
    const TYPE_DELETE = 3;
    const TYPE_LOGIN = 10;
    const TYPE_LOGOUT = 11;

    protected $saveHistory = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['data'], 'string'],
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

    public function setData($data)
    {
        $this->data = Json::encode($data);
    }

    public function getData()
    {
        return Json::decode($this->data);
    }

    public static function createModel($type, $className, $attributes = [])
    {
        try {
            $model = new self();
            $model->type = $type;
            $model->model = $className;
            $model->setData($attributes);
            $model->save();

        } catch (\Exception $e) {
        }
    }
}
