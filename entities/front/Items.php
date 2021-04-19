<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Entities;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Items extends \afzalroq\cms\entities\Items
{

    public static function getAll($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findAll(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, $cacheDuration, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public static function get($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findOne(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, $cacheDuration, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public function getText1()
    {
        return $this->getText('text_1');
    }

    private function getText($entityAttr)
    {
        return $this[$this->getAttr($entityAttr)];
    }

    private function getAttr($entityAttr)
    {
        if (!($languageId = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language]))
            $languageId = 0;

        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $languageId);
    }

    public function getText2()
    {
        return $this->getText('text_2');
    }

    public function getText3()
    {
        return $this->getText('text_3');
    }

    public function getText4()
    {
        return $this->getText('text_4');
    }

    public function getText5()
    {
        return $this->getText('text_5');
    }

    public function getText6()
    {
        return $this->getText('text_6');
    }

    public function getText7()
    {
        return $this->getText('text_7');
    }

    public function getMeta()
    {
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->getMetaDescription()
        ]);

        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->getMetaKeyword()
        ]);
    }

    private function getMetaDescription()
    {
        return $this->getSeo('meta_des');
    }

    private function getMetaKeyword()
    {
        return $this->getSeo('meta_keyword');
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto1($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_1', $width, $height, $operation, $background, $xPos, $yPos);
    }

    private function getPhoto($entityAttr, $width, $height, $operation, $background, $xPos, $yPos)
    {
        return $this->getImageUrl($this->getAttr($entityAttr), $width, $height, $operation, $background, $xPos, $yPos);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto2($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_2', $width, $height, $operation, $background, $xPos, $yPos);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto3($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_3', $width, $height, $operation, $background, $xPos, $yPos);
    }

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    private function getFile($entityAttr)
    {
        $module = Yii::$app->getModule('cms');
        $filePath = $module->path . '/data/' . mb_strtolower(StringHelper::basename($this::className())) . '/' . $this->id . '/' . $this[$this->getAttr($entityAttr)];
        return $module->host . str_replace($module->path, '', $filePath);
    }

    public function getFile2()
    {
        return $this->getFile('file_2');
    }

    public function getFile3()
    {
        return $this->getFile('file_3');
    }

    public function getDate($format)
    {
        return date($format, $this->date);
    }

    private function getMetaTitle()
    {
        return $this->getSeo('meta_title');
    }

    private function getSeo($seoAttr)
    {
        if (!($languageId = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language]))
            $languageId = 0;
        if (empty($this->seo_values))
            return null;
        return $this->seo_values[$seoAttr . '_' . $this->languageId];
    }
}
