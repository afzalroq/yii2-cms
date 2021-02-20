<?php

namespace afzalroq\cms\assets;

use kartik\base\AssetBundle;

class OptionsNestableAsset extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__);
        $this->setupAssets('js', ['js/jquery.options.nestable']);
        $this->setupAssets('css', ['css/nestable']);
        $this->publishOptions = [
            'only' => [
                'css/*',
                'js/*'
            ]
        ];
        parent::init();
    }
}