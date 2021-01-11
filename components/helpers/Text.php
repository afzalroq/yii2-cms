<?php

namespace afzalroq\cms\components\helpers;

use afzalroq\cms\components\Image;
use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Options;
use yii\db\ActiveRecord;

class Text extends BaseHelper
{
    public $strip_tags;

    public function addStripTags()
    {
        $this->strip_tags = true;
        return $this;
    }
    public function removeStripTags()
    {
        $this->strip_tags = false;
        return $this;
    }

    public function getText1($langKey = 0)
    {
        return $this->obj->{"text_1_" . "$langKey"};
    }

    public function getText2($langKey = 0)
    {
        return $this->obj->{"text_2_" . "$langKey"};
    }

    public function getText3($langKey = 0)
    {
        return $this->obj->{"text_3_" . "$langKey"};
    }

    public function getText4($langKey = 0)
    {
        return $this->obj->{"text_4_" . "$langKey"};
    }

    public function getText5($langKey = 0)
    {
        return $this->obj->{"text_5_" . "$langKey"};
    }

    public function getText6($langKey = 0)
    {
        return $this->obj->{"text_6_" . "$langKey"};
    }

    public function getText7($langKey = 0)
    {
        return $this->obj->{"text_7_" . "$langKey"};
    }

}