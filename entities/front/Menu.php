<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Entities;
use slatiusa\nestable\Nestable;
use afzalroq\cms\widgets\menu\MenuWidget;
use afzalroq\cms\widgets\menu\OptionWidget;
use yii\base\BaseObject;
use yii\caching\TagDependency;
use Yii;

class Menu extends Nestable
{
    public static function getMenu($slug, $is_menu = true)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        $cacheName = $is_menu ? 'menu_' : 'options_';
        return \Yii::$app->{$cache}->getOrSet($cacheName . $slug . Yii::$app->language, function () use ($slug, $is_menu) {
            return ($is_menu ? new MenuWidget() : new OptionWidget())->getMenu($slug)[0]['children'];
        }, $cacheDuration, new TagDependency(['tags' => [$cacheName . $slug]]));
    }
}
