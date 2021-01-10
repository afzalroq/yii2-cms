<?php

namespace afzalroq\cms\components\helpers;

use afzalroq\cms\components\Image;
use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Options;
use yii\db\ActiveRecord;

class Text
{
    public $obj;
    public $strip_tags;
    public $languageId;

    /**
     * Text constructor.
     * @param Options|Items $obj
     */
    public function __construct(ActiveRecord $obj)
    {
        $this->obj = $obj;
    }

    public function addStripTags()
    {
        $this->strip_tags = true;
        return $this;
    }

    public function getText($dependAttr, $langKey = 0)
    {
        $text = $this->obj->{$dependAttr . "_" . "$langKey"};

        if ($this->strip_tags)
            return strip_tags($text);

        return $text;

    }

    public function getPhoto($dependAttr, $langKey = 0, $width = null, $height = null)
    {
        return $this->obj->getImageUrl($dependAttr . "_" . "$langKey", $width, $height);
    }
}