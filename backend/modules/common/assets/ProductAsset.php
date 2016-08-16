<?php

namespace backend\modules\management\modules\common\assets;

class ProductAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/management/modules/common/assets/source/js';
    public $js
        = [
            'form-append.js',
        ];

    public $depends
        = [
            'backend\assets\AppAsset',
        ];
}
