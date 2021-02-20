<?php

namespace afzalroq\cms\assets;

use kartik\base\AssetBundle;

class CmsNestableAsset extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__);
        $this->setupAssets('js', ['js/jquery.nestable']);
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