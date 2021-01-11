<?php


namespace afzalroq\cms\components\helpers;


use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Options;
use yii\db\ActiveRecord;

class BaseHelper
{
    public $obj;
    public $languageId;

    /**
     * Text constructor.
     * @param Options|Items $obj
     */
    public function __construct(ActiveRecord $obj)
    {
        $this->obj = $obj;
    }

}