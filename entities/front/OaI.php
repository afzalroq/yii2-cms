<?php

namespace afzalroq\cms\entities\front;


use afzalroq\cms\entities\Collections;

class OaI extends \afzalroq\cms\entities\OaI
{

    public static function getItemIdsByCollection($slug)
    {
        $optionIds = Options::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])])->select('id')->column();
        return self::find()->select('item_id')->where(['option_id' => $optionIds])->column();
    }

    public static function getItemIdsByOption($slug)
    {
        $optionIds = Options::find()->where(['slug' => $slug])->select('id')->column();
        return self::find()->select('item_id')->where(['option_id' => $optionIds])->column();
    }
}
