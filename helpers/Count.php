<?php

namespace afzalroq\cms\helpers;


use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\front\Items;
use afzalroq\cms\entities\front\Options;
use Yii;
use yii\caching\TagDependency;


class Count
{
    public static function countItem($slug)
    {
        return Items::find()->where(['entity_id' => Entities::findOne(['slug' => $slug])->id])->count();
    }

    public static function countOption($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return Yii::$app->{$cache}->getOrSet('options_' . $slug, function () use ($slug) {
            return Options::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->count();
        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }
}
