<?php

namespace afzalroq\cms;

use yii\base\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        if (!isset($app->i18n->translations['cms']) && !isset($app->i18n->translations['cms*'])) {
            $app->i18n->translations['cms'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }
        if (!isset($app->i18n->translations['unit']) && !isset($app->i18n->translations['unit*'])) {
            $app->i18n->translations['unit'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }
    }
}
