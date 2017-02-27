<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $css
        = [
            'css/site.css',
        ];

    public $js
        = [
            'js/main.js',
            'js/modal-form.js',
            'js/pjax-action.js',
        ];

    public $depends
        = [
            'yiister\gentelella\assets\Asset',
//            'yii\bootstrap\BootstrapAsset',
//            'yii\web\YiiAsset',
        ];
}
