<?php

namespace afzalroq\cms;

use kartik\datecontrol\Module;
use yii\base\BootstrapInterface;
use yii\web\Application;


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
        $app->bootstrap[] = 'cms';
        $app->setModules([
            'datecontrol' => [
                'class' => 'kartik\datecontrol\Module',

                // format settings for displaying each date attribute (ICU format example)
                'displaySettings' => [
                    Module::FORMAT_DATE => 'dd-MM-yyyy',
                    Module::FORMAT_TIME => 'HH:i:s',
                    Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:i:s',
                ],

                // format settings for saving each date attribute (PHP format example)
                'saveSettings' => [
                    Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
                    Module::FORMAT_TIME => 'php:H:i:s',
                    Module::FORMAT_DATETIME => 'php:U',
                ],

                // set your display timezone
                'displayTimezone' => 'Asia/Tashkent',

                // set your timezone for date saved to db
                'saveTimezone' => 'UTC',

                // automatically use kartik\widgets for each of the above formats
                'autoWidget' => true,

                // use ajax conversion for processing dates from display format to save format.
                'ajaxConversion' => true,

                // default settings for each widget from kartik\widgets used when autoWidget is true
                'autoWidgetSettings' => [
                    Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true, 'todayBtn' => true]], // example
                    Module::FORMAT_DATETIME => ['pluginOptions' => ['autoclose' => true, 'todayBtn' => true]], // setup if needed
                    Module::FORMAT_TIME => [], // setup if needed
                ],

                // custom widget settings that will be used to render the date input instead of kartik\widgets,
                // this will be used when autoWidget is set to false at module or widget level.
                'widgetSettings' => [
                    Module::FORMAT_DATE => [
                        'class' => 'yii\jui\DatePicker', // example
                        'options' => [
                            'dateFormat' => 'php:d-M-Y',
                            'options' => ['class' => 'form-control'],
                        ]
                    ]
                ]
                // other settings
            ]
        ]);

        $app->on(Application::EVENT_BEFORE_REQUEST, [$this, 'addModuleUrlRules']);
    }

    public function addModuleUrlRules($event)
    {
        \Yii::$app->getUrlManager()->addRules([
            'c/<c:[\w+-]+>' => 'c/collection',
            'c/<c:[\w+-]+>/<o:[\w+-]+>' => 'c/option',

            'e/<e:[\w+-]+>' => 'c/entity',
            'e/<e:[\w+-]+>/<i:\d+>-<w:[\w+-]*>' => 'c/item',
        ]);
    }
}
