<?php

namespace common\assets;

class FormAppendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $js
        = [
            'js/form-append.js',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
