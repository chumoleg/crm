<?php

namespace common\assets\company;

class CompanyListAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $js
        = [
            'js/company/company-list.js',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
