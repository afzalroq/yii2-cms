<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Options extends \afzalroq\cms\entities\Options
{
    #region Method Aliases

    #region Get Photo Attributes

    public function getPhoto1($width = null, $height = null)
    {
        return $this->getPhoto('file_1', $width, $height);
    }

    public function getPhoto2($width, $height)
    {
        return $this->getPhoto('file_2', $width, $height);
    }

    #endregion

    #region Get File Attributes

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    public function getFile2()
    {
        return $this->getFile('file_2');
    }

    #endregion

    #endregion

    #region Base Methods

    public function getName()
    {
        if (!($attr = $this->getAttr('name')))
            return null;

        return $this[$attr];
    }

    public function getContent()
    {
        if (!($attr = $this->getAttr('content')))
            return null;

        return $this[$attr];
    }

    public function getPhoto($collectionAttr, $width, $height)
    {
        if (!($attr = $this->getAttr($collectionAttr)))
            return null;

        return $this->getImageUrl($attr, $width, $height);
    }

    public function getFile($collectionAttr)
    {
        if (!($attr = $this->getAttr($collectionAttr)))
            return null;

        $filePath = Yii::getAlias('@storage/data/' . mb_strtolower(StringHelper::basename($this::className())) . '/')
            . $this->id . '/'
            . $this[$attr];

        return 'http://localhost:20082' . str_replace('/app/storage', '', $filePath);
    }

    #endregion

    #region GetOrSet Cached Items

    public static function getAll($slug)
    {
        return \Yii::$app->cmsCache->getOrSet('options_' . $slug, function () use ($slug) {

            return self::findAll(['collection_id' => Collections::findOne(['slug' => $slug])->id]);

        }, 0, new TagDependency(['tags' => ['options-' . $slug]]));
    }

    public static function get($slug)
    {
        return \Yii::$app->cmsCache->getOrSet('options_' . $slug, function () use ($slug) {

            return self::findOne(['collection_id' => Collections::findOne(['slug' => $slug])->id]);

        }, 0, new TagDependency(['tags' => ['options-' . $slug]]));
    }

    #endregion

    #region Extra Methods

    private function getAttr($collectionAttr)
    {
        if ($this->isAttrDisabled($collectionAttr))
            return null;

        if ($this->isAttrCommon($collectionAttr))
            $attr = $collectionAttr . '_0';
        else
            $attr = $collectionAttr . "_" . "$this->languageId";

        return $attr;
    }

    #endregion
}