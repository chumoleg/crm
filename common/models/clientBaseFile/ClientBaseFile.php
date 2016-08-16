<?php

namespace common\models\clientBaseFile;

use common\components\base\ActiveRecord;
use common\components\helpers\ArrayHelper;

/**
 * This is the model class for table "client_base_file".
 *
 * @property integer              $id
 * @property string               $client_name
 * @property string               $server_name
 * @property string               $date_create
 *
 * @property ClientBaseFileData[] $clientBaseFileDatas
 */
class ClientBaseFile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_base_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_name', 'server_name'], 'required'],
            [['date_create'], 'safe'],
            [['client_name', 'server_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'client_name' => 'Название файла',
            'server_name' => 'Server Name',
            'date_create' => 'Дата загрузки',
            'countRows'   => 'Кол-во записей',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientBaseFileDatas()
    {
        return $this->hasMany(ClientBaseFileData::className(), ['client_base_file_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $data = self::find()->all();
        return ArrayHelper::map($data, 'id', 'client_name');
    }
}
