<?php

namespace call\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/web/source';
    public $css
        = [
            'css/site.css',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
