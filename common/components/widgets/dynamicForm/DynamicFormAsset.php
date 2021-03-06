<?php

namespace common\components\widgets\dynamicForm;

class DynamicFormAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends
        = [
            'yii\web\JqueryAsset',
            'yii\widgets\ActiveFormAsset'
        ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['yii2-dynamic-form']);
        parent::init();
    }

    /**
     * Set up CSS and JS asset arrays based on the base-file names
     *
     * @param string $type  whether 'css' or 'js'
     * @param array  $files the list of 'css' or 'js' basefile names
     */
    protected function setupAssets($type, $files = [])
    {
        $srcFiles = [];
        foreach ($files as $file) {
            $srcFiles[] = "{$file}.{$type}";
        }

        if (empty($this->$type)) {
            $this->$type = $srcFiles;
        }
    }

    /**
     * Sets the source path if empty
     *
     * @param string $path the path to be set
     */
    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }
}
