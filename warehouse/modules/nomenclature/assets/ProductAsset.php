<?php

namespace warehouse\modules\nomenclature\assets;

class ProductAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/source/js';
    public $js
        = [
            'form-append.js',
        ];

    public $depends
        = [
            'warehouse\assets\AppAsset',
        ];
}
