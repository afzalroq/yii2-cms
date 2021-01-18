<?php


namespace afzalroq\cms\entities\front;


use afzalroq\cms\entities\Entities;
use yii\caching\TagDependency;

class Items extends \afzalroq\cms\entities\Items
{
    #region Get Text Attributes

    public function getText1()
    {
        return $this->getText('text_1');
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

    #region Base Methods

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
    
    #endregion

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