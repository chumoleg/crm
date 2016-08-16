<?php

namespace warehouse\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
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
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
}
