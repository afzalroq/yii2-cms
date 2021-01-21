<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Options extends \afzalroq\cms\entities\Options
{

    public static function getAll($slug)
    {
        return \Yii::$app->cache->getOrSet('options_' . $slug, function () use ($slug) {
            return self::findAll(['collection_id' => Collections::findOne(['slug' => $slug])->id]);
        }, 3600, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    public static function get($slug)
    {
        return \Yii::$app->cache->getOrSet('options_' . $slug, function () use ($slug) {
            return self::findOne(['collection_id' => Collections::findOne(['slug' => $slug])->id]);
        }, 3600, new TagDependency(['tags' => ['options_' . $slug]]));
    }


    public function getPhoto1($width = null, $height = null)
    {
        return $this->getPhoto('file_1', $width, $height);
    }

    private function getPhoto($collectionAttr, $width, $height)
    {
        return $this->getImageUrl($this->getAttr($collectionAttr), $width, $height);
    }

    private function getAttr($entityAttr)
    {
        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $this->languageId);
    }

    public function getPhoto2($width, $height)
    {
        return $this->getPhoto('file_2', $width, $height);
    }

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    private function getFile($collectionAttr)
    {
        $filePath = \Yii::getAlias('@storage/data/' . mb_strtolower(StringHelper::basename($this::className()))) . '/' . $this->id . '/' . $this[$this->getAttr($collectionAttr)];
        return 'http://localhost:20082' . str_replace('/app/storage', '', $filePath);
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
