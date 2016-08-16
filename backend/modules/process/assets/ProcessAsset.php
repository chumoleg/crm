<?php

namespace backend\modules\management\modules\process\assets;

class ProcessAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/management/modules/process/assets/source/js';
    public $js
        = [
            'process.js',
        ];

    public $depends
        = [
            'backend\assets\AppAsset',
        ];
}
