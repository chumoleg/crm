<?php

namespace call\modules\clientBase\forms;

use Yii;
use common\components\base\Model;
use yii\web\UploadedFile;

class OrderLoadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [
                ['file'],
                'file',
                'skipOnEmpty'              => false,
                'checkExtensionByMimeType' => false,
                'extensions'               => ['xls', 'csv'],
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $serverName = md5($this->file->baseName . '_' . time()) . '.' . $this->file->extension;
            if (!$this->file->saveAs(Yii::$app->getRuntimePath() . '/' . $serverName)) {
                return false;
            }

            $clientName = $this->file->baseName . '.' . $this->file->extension;
            Yii::$app->consoleRunner->run('order/load-from-file --clientFileName='
                . $clientName . ' --serverFileName=' . $serverName);

            return true;

        } else {
            return false;
        }
    }
}
