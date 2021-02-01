<?php

namespace afzalroq\cms\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class CmsNestableAsset extends \kartik\base\AssetBundle
{
    public function init() {
        $this->setSourcePath(__DIR__);
        $this->setupAssets('js', ['js/jquery.nestable']);
        $this->setupAssets('css', ['css/nestable']);
        parent::init();
    }
}