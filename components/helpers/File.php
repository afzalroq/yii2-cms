<?php

namespace afzalroq\cms\components\helpers;

use afzalroq\cms\components\Image;
use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Options;
use yii\db\ActiveRecord;

class File extends BaseHelper
{
    public function getPhoto1($langKey = 0, $width = null, $height = null)
    {
        return $this->obj->getImageUrl("file_1_" . "$langKey", $width, $height);
    }

    public function getPhoto2($langKey = 0, $width = null, $height = null)
    {
        return $this->obj->getImageUrl("file_2_" . "$langKey", $width, $height);
    }

    public function getPhoto3($langKey = 0, $width = null, $height = null)
    {
        return $this->obj->getImageUrl("file_3_" . "$langKey", $width, $height);
    }
}