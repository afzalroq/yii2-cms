<?php


namespace afzalroq\cms\entities\front;


use afzalroq\cms\entities\Entities;
use yii\caching\TagDependency;

class Options extends \afzalroq\cms\entities\Options
{
    #region Get Text Attributes
    public function getName1()
    {
        return $this->getText('text_1');
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

    public function getPhoto3($width, $height)
    {
        return $this->getPhoto('file_3', $width, $height);
    }

    #endregion

    public function getText($entityAttr)
    {

        if ($this->isAttrCommon($entityAttr))
            return $this[$entityAttr . '_0'];

        return $this[$entityAttr . '_' . $this->languageId];

    }

    public function getPhoto($entityAttr, $width, $height)
    {
        if ($this->isAttrDisabled($entityAttr))
            return null;

        if ($this->isAttrCommon($entityAttr))
            return $this->getImageUrl($entityAttr . '_0', $width, $height);

        return $this->getImageUrl($entityAttr . "_" . "$this->languageId", $width, $height);
    }

    #region GetOrSet Cached Items
    public static function getAll($slug)
    {
        return \Yii::$app->cmsCache->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findAll(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, 0, new TagDependency(['tags' => ['items-' . $slug]]));
    }

    public static function get($slug)
    {
        return \Yii::$app->cmsCache->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findOne(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, 0, new TagDependency(['tags' => ['items-' . $slug]]));
    }
    #endregion

}