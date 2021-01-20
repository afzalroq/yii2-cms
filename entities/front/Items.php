<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Entities;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Items extends \afzalroq\cms\entities\Items
{
    #region Method Aliases

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

    public function getPhoto2($width = null, $height = null)
    {
        return $this->getPhoto('file_2', $width, $height);
    }

    public function getPhoto3($width = null, $height = null)
    {
        return $this->getPhoto('file_3', $width, $height);
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

    public function getFile3()
    {
        return $this->getFile('file_3');
    }

    #endregion

    #endregion

    #region Base Methods

    public function getText($entityAttr)
    {
        if (!($attr = $this->getAttr($entityAttr)))
            return null;

        return $this[$attr];
    }

    public function getPhoto($entityAttr, $width, $height)
    {
        if (!($attr = $this->getAttr($entityAttr)))
            return null;

        return $this->getImageUrl($attr, $width, $height);
    }

    public function getFile($entityAttr)
    {
        if (!($attr = $this->getAttr($entityAttr)))
            return null;

        $filePath = Yii::getAlias('@storage/data/' . mb_strtolower(StringHelper::basename($this::className())) . '/')
            . $this->id . '/'
            . $this[$attr];

        return 'http://localhost:20082' . str_replace('/app/storage', '', $filePath);
    }

    public function getDate($format)
    {
        return date($format, $this->date);
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

    #region Extra Methods

    private function getAttr($entityAttr)
    {
        if ($this->isAttrDisabled($entityAttr))
            return null;

        if ($this->isAttrCommon($entityAttr))
            $attr = $entityAttr . '_0';
        else
            $attr = $entityAttr . "_" . "$this->languageId";

        return $attr;
    }

    #endregion
}