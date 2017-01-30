<?php

namespace common\components\base;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\history\History;
use common\components\Status;
use common\components\helpers\ArrayHelper;
use common\models\user\User;

class ActiveRecord extends \yii\db\ActiveRecord
{
    protected $saveHistory = true;

    /**
     * @param int $id
     *
     * @return static|null
     */
    public static function findById($id)
    {
        if (empty($id)) {
            return null;
        }

        return self::find()->andWhere(['id' => (int)$id])->one();
    }

    public function beforeSave($insert)
    {
        if (array_key_exists('date_create', $this->attributes)) {
            $this->date_create = date('Y-m-d H:i:s');
        }

        if (array_key_exists('user_id', $this->attributes) && empty($this->user_id)) {
            $user = Yii::$app->get('user', false);
            $this->user_id = $user && !$user->isGuest ? $user->id : User::ADMIN_USER;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function setStatus($status)
    {
        if (empty($this->id)) {
            return false;
        }

        if (!isset($this->status)) {
            return true;
        }

        $this->status = $status;
    }

    public function setDisabled()
    {
        return $this->setStatus(Status::STATUS_NOT_ACTIVE);
    }

    public function setActive()
    {
        return $this->setStatus(Status::STATUS_ACTIVE);
    }

    public function getStatusLabel()
    {
        $list = Status::getStatusList();

        return ArrayHelper::getValue($list, $this->status);
    }

    public function isActive()
    {
        return $this->status == Status::STATUS_ACTIVE;
    }

    public function isDisabled()
    {
        return $this->status == Status::STATUS_NOT_ACTIVE;
    }

    public function getReflectionClassName()
    {
        $reflect = new \ReflectionClass($this->className());

        return $reflect->getShortName();
    }

    /**
     * @param        $query
     * @param array  $defaultOrder
     *
     * @return ActiveDataProvider
     */
    protected function getDataProvider($query, $defaultOrder = [])
    {
        if (empty($defaultOrder)) {
            $defaultOrder = ['id' => SORT_DESC];
        }

        return new ActiveDataProvider(
            [
                'query'      => $query,
                'sort'       => [
                    'defaultOrder' => $defaultOrder,
                ],
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $data = self::find()->all();

        return ArrayHelper::map($data, 'id', 'name');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->saveHistory) {
            $type = History::TYPE_CREATE;
            if (!$this->isNewRecord) {
                $type = History::TYPE_UPDATE;
            }

            $this->_saveHistory($type);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->saveHistory) {
            $this->_saveHistory(History::TYPE_DELETE);
        }
    }

    private function _saveHistory($type)
    {
        $model = new History();
        $model->type = $type;
        $model->model = $this->className();
        $model->setData($this->getAttributes());
        $model->save();
    }
}