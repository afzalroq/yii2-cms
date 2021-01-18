<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use yii\caching\TagDependency;

class Options extends \afzalroq\cms\entities\Options
{
    #region Get Text Attributes

    public function getName()
    {
        if ($this->isAttrCommon('name'))
            return $this['name_0'];

        return $this['name_' . $this->languageId];
    }

    public function getContent()
    {
        if ($this->isAttrCommon('content'))
            return $this['content_0'];

        return $this['content_' . $this->languageId];
    }

    #endregion

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

    public function getPhoto($collectionAttr, $width, $height)
    {
        if ($this->isAttrDisabled($collectionAttr))
            return null;

        if ($this->isAttrCommon($collectionAttr))
            return $this->getImageUrl($collectionAttr . '_0', $width, $height);

        return $this->getImageUrl($collectionAttr . "_" . "$this->languageId", $width, $height);
    }

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
}