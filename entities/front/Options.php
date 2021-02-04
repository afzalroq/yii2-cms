<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Options extends \afzalroq\cms\entities\Options
{

    public static function getAll($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return Yii::$app->{$cache}->getOrSet('options_' . $slug, function () use ($slug) {
            return self::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->all();
        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    public static function get($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return Yii::$app->{$cache}->getOrSet('options_' . $slug, function () use ($slug) {
            return self::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->one();
        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto1($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_1', $width, $height, $operation, $background, $xPos, $yPos);
    }

    private function getPhoto($collectionAttr, $width, $height, $operation, $background, $xPos, $yPos)
    {
        return $this->getImageUrl($this->getAttr($collectionAttr), $width, $height, $operation, $background, $xPos, $yPos);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto2($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_2', $width, $height, $operation, $background, $xPos, $yPos);
    }

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    private function getFile($collectionAttr)
    {
        $module = Yii::$app->getModule('cms');
        $filePath = $module->path . '/data/' . mb_strtolower(StringHelper::basename($this::className())) . '/' . $this->id . '/' . $this[$this->getAttr($collectionAttr)];
        return $module->host . str_replace($module->path, '', $filePath);
    }

    private function getAttr($entityAttr)
    {
        if (!($languageId = Yii::$app->params['cms']['languageIds'][Yii::$app->language]))
            $languageId = 0;

        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $languageId);
    }

    public function getFile2()
    {
        return $this->getFile('file_2');
    }

    public function getName()
    {
        return $this[$this->getAttr('name')];
    }

    public function getContent()
    {
        return $this[$this->getAttr('content')];
    }
}
