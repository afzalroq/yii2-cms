<?php

namespace afzalroq\cms\entities;

class HelperItem extends Items
{
    public $languageId;

    public function init()
    {
        parent::init();
        $this->setCurrentLanguage();
    }

    #region Get Text Attributes
    public function getText1()
    {
        return $this['text_1_' . $this->languageId];
    }

    public function getText2()
    {
        return $this['text_2_' . $this->languageId];
    }

    public function getText3()
    {
        return $this['text_3_' . $this->languageId];
    }

    public function getText4()
    {
        return $this['text_4_' . $this->languageId];
    }

    public function getText5()
    {
        return $this['text_5_' . $this->languageId];
    }

    public function getText6()
    {
        return $this['text_6_' . $this->languageId];
    }

    public function getText7()
    {
        return $this['text_7_' . $this->languageId];
    }
    #endregion

    #region Get Photo Attributes
    public function getPhoto1($width = null, $height = null)
    {
        $imageUrl = $this->getImageUrl("file_1_" . "$this->languageId", $width, $height);
        return $imageUrl;
    }

    public function getPhoto2($width, $height)
    {
        return $this->getImageUrl("file_2_" . "$this->languageId", $width, $height);
    }

    public function getPhoto3($width, $height)
    {
        return $this->getImageUrl("file_3_" . "$this->languageId", $width, $height);
    }

    #endregion

    private function setCurrentLanguage()
    {
        $this->languageId = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language];
        if (!$this->languageId)
            $this->languageId = 0;
    }
}