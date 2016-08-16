<?php

namespace common\models\clientBaseFile;

use common\components\base\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "client_base_file_data".
 *
 * @property integer        $id
 * @property integer        $client_base_file_id
 * @property string         $fio
 * @property string         $phone
 * @property string         $data
 * @property string         $duplicate_hash
 * @property string         $date_create
 *
 * @property ClientBaseFile $clientBaseFile
 */
class ClientBaseFileData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_base_file_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_base_file_id', 'duplicate_hash'], 'required'],
            [['client_base_file_id'], 'integer'],
            [['data'], 'string'],
            [['fio', 'phone', 'date_create'], 'safe'],
            [['duplicate_hash'], 'string', 'max' => 32],
            [['duplicate_hash'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => 'ID',
            'client_base_file_id' => 'Файл',
            'fio'                 => 'ФИО',
            'phone'               => 'Телефон',
            'data'                => 'Доп. данные',
            'duplicate_hash'      => 'Duplicate Hash',
            'date_create'         => 'Дата загрузки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientBaseFile()
    {
        return $this->hasOne(ClientBaseFile::className(), ['id' => 'client_base_file_id']);
    }

    public function beforeValidate()
    {
        $this->duplicate_hash = md5($this->fio . '_' . $this->phone);
        $this->data = Json::encode($this->data);

        return parent::beforeValidate();
    }

    public function getData()
    {
        return Json::decode($this->data);
    }
}
