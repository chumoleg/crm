<?php

namespace common\models\project;

use common\components\base\ActiveRecord;
use common\components\Role;
use common\models\user\User;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $comment
 * @property integer $status
 * @property string $date_create
 * @property string $label_class
 */
class Project extends ActiveRecord
{
    public static $labelClassList
        = [
            'label-default' => 'Серый',
            'label-primary' => 'Синий',
            'label-success' => 'Зеленый',
            'label-info'    => 'Голубой',
            'label-warning' => 'Оранжевый',
            'label-danger'  => 'Красный',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'comment', 'status'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['label_class'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Проект',
            'user_id' => 'Пользователь',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'date_create' => 'Дата создания',
            'label_class' => 'Цвет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOperatorList()
    {
        return User::getListByRole(Role::OPERATOR);
    }
}
