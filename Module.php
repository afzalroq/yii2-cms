<?php

namespace afzalroq\cms;

use afzalroq\cms\components\Language;

/**
 * Class Module
 * @package afzalroq\cms
 * @property string $path
 * @property string $host
 * @property string $cache
 * @property integer $cacheDuration
 * @property string $fallback
 * @property string $watermark
 * @property integer $watermarkBottom
 * @property integer $watermarkRight
 * @property string $imageOperation
 * @property string $imageBackground
 * @property string $imageXPos
 * @property string $imageYPos
 * @property array|null $textConverter
 * @property array $languages
 * @property array $menuActions
 */
class Module extends \yii\base\Module
{
    public $userClass = '\common\models\User';
    public $frontHost;
    public $path;
    public $host;
    public $cache = 'cache';
    public $cacheDuration = YII_ENV_DEV ? 1 : 3600;
    public $fallback;
    public $watermark;
    public $watermarkBottom = 15;
    public $watermarkRight = 15;
    public $imageOperation = 'cropResize';
    public $imageBackground = 'transparent';
    public $imageXPos = 'center';
    public $imageYPos = 'center';
    public $textConverter = false;
    public $languages;
    public $menuActions;
    public $optimized = false;
    public $pageSize = 10;
    
    private static function dataKeys()
    {
        return [0, 1, 2, 3, 4];
    }

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
            //deprecated
            \Yii::$app->params['cms']['languageIds'][$prefix] = $language['id'];
            \Yii::$app->params['cms']['languages'][$language['id']] = $language['name'];

            // preferred params
            \Yii::$app->params['l-name'][$language['id']] = $language['name'];
            \Yii::$app->params['l-name'][$prefix] = $language['name'];
            \Yii::$app->params['l'][$language['id']] = $prefix;
            \Yii::$app->params['l'][$prefix] = $language['id'];
        }
    }

    private function validateLanguages()
    {
        if (count(array_diff(\Yii::$app->params['cms']['languageIds'], self::dataKeys()))) {
            throw new \RuntimeException('Language key is invalid. Current support keys range is ' . json_encode(self::dataKeys()));
        }
    }

}
