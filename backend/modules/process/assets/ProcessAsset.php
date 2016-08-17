<?php

namespace backend\modules\process\assets;

class ProcessAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/process/assets/source/js';
    public $js
        = [
            'process.js',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
