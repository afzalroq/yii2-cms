<?php

namespace abdualiym\cms;

use abdualiym\cms\entities\Menu;
use abdualiym\language\Language;

/**
 * Class Module
 * @package abdualiym\cms
 * @property string $storageRoot
 * @property string $storageHost
 * @property array $thumbs
 * @property array $languages
 * @property array $menuActions
 */
class Module extends \yii\base\Module
{

    public $storageRoot;
    public $storageHost;
    public $thumbs;
    public $languages;
    public $menuActions;

    public function init()
    {
        parent::init();
        $this->registerAppParams();
        $this->validateLanguages();
    }

    private function registerAppParams()
    {
        $languageIds = [];
        foreach ($this->languages as $prefix => $language) {
            \Yii::$app->params['cms']['languageIds'][$prefix] = $language['id'];
            \Yii::$app->params['cms']['languages'][$prefix] = $language['name'];
            \Yii::$app->params['cms']['languages2'][$language['id']] = $language['name'];
        }
    }

    private function validateLanguages()
    {
        if (count(array_diff(\Yii::$app->params['cms']['languageIds'], Language::dataKeys()))) {
            throw new \RuntimeException('Language key is invalid. Current support keys range is ' . json_encode(Language::dataKeys()));
        }
    }
}
