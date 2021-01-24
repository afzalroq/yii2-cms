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
        return \Yii::$app->cache->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findAll(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, 3600, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public static function get($slug)
    {
        return \Yii::$app->cache->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findOne(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, 3600, new TagDependency(['tags' => ['items_' . $slug]]));
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
        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $this->languageId);
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

    public function getPhoto1($width = null, $height = null, $resizeType = null)
    {
        return $this->getPhoto('file_1', $width, $height, $resizeType);
    }

    private function getPhoto($entityAttr, $width, $height, $resizeType)
    {
        return $this->getImageUrl($this->getAttr($entityAttr), $width, $height, $resizeType);
    }

    public function getPhoto2($width = null, $height = null, $resizeType = null)
    {
        return $this->getPhoto('file_2', $width, $height, $resizeType);
    }

    public function getPhoto3($width = null, $height = null, $resizeType = null)
    {
        return $this->getPhoto('file_3', $width, $height);
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
}
