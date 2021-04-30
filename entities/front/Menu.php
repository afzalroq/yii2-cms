<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Entities;
use slatiusa\nestable\Nestable;
use afzalroq\cms\widgets\menu\MenuWidget;
use yii\base\BaseObject;
use yii\caching\TagDependency;
use Yii;

class Menu extends Nestable
{
    public static function getMenu($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('menu_' . $slug, function () use ($slug) {
            return (new MenuWidget())->getMenu($slug);
        }, $cacheDuration, new TagDependency(['tags' => ['menu_' . $slug]]));
    }
}
