<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\interfaces\Linkable;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Options extends \afzalroq\cms\entities\Options implements Linkable
{

    public $dependCollection;

    public function __construct($slug = null, $config = [])
    {
        if ($slug) {
            $this->dependCollection = Collections::findOne(['slug' => $slug]);
            if ($this->dependCollection->manual_slug) $this->detachBehavior('slug');
        } else {
            $this->dependCollection = $this->collection;
        }
        $this->setCurrentLanguage();
        parent::__construct($config);
    }

    private function setCurrentLanguage()
    {
        $this->languageId = \Yii::$app->params['l'][\Yii::$app->language];
        if (!$this->languageId)
            $this->languageId = 0;
    }

    public static function getAll($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return Yii::$app->{$cache}->getOrSet('options_' . $slug, function () use ($slug) {
            return self::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->orderBy('sort')->all();
        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    public static function get($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return Yii::$app->{$cache}->getOrSet('options_' . $slug, function () use ($slug) {
            return self::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->one();
        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    public static function getWithOptions($slug, array $orderBy = null, $limit = null, $status = null)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('options_' . $slug . $orderBy ?? $orderBy . $limit ?? $limit . $status ?? $status, function () use ($slug, $orderBy, $limit, $status) {
            $query = self::find()->where(['collection_id' => Collections::findOne(['slug' => $slug])->id])->andWhere(['>', 'depth', 0])->orderBy('sort');
            if ($orderBy)
                $query->orderBy($orderBy);
            if ($status)
                $query->where(['status' => $status]);
            if ($limit)
                $query->limit($limit);
            return $query->all();

        }, $cacheDuration, new TagDependency(['tags' => ['options_' . $slug]]));
    }

    public static function getOptionSearchResults(array $optionSlugs, $search)
    {
        $langId = Yii::$app->params['cms']['languageIds'][Yii::$app->language];
        $query = Options::find()->where(['slug' => $optionSlugs]);
        $options = $query->andFilterWhere(['or',
            ['like', 'name_' . $langId, $search],
            ['like', 'content_' . $langId, $search],
        ])->all();
        return $options;
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto1($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_1', $width, $height, $operation, $background, $xPos, $yPos);
    }

    private function getPhoto($collectionAttr, $width, $height, $operation, $background, $xPos, $yPos)
    {
        return $this->getImageUrl($this->getAttr($collectionAttr), $width, $height, $operation, $background, $xPos, $yPos);
    }

    private function getAttr($collectionAttr)
    {
        if (!($languageId = Yii::$app->params['cms']['languageIds'][Yii::$app->language]))
            $languageId = 0;

        return $collectionAttr . ($this->isAttrCommon($collectionAttr) ? '_0' : "_" . $languageId);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto2($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_2', $width, $height, $operation, $background, $xPos, $yPos);
    }

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    private function getFile($collectionAttr)
    {
        $module = Yii::$app->getModule('cms');
        $filePath = 'data/' . mb_strtolower(StringHelper::basename($this::className())) . '/' . $this->id . '/' . $this[$this->getAttr($collectionAttr)];
        return $module->host . $filePath;
    }

    public function getFile2()
    {
        return $this->getFile('file_2');
    }

    public function getName()
    {
        return $this[$this->getAttr('name')];
    }

    public function getContent()
    {
        return $this[$this->getAttr('content')];
    }

    public function getText1()
    {
        return $this->getText('text_1');
    }

    private function getText($collectionAttr)
    {

        return $this[$this->getAttrOption($collectionAttr)];
    }

    private function getAttrOption($collectionAttr)
    {
        if (!($languageId = \Yii::$app->params['l'][\Yii::$app->language]))
            $languageId = 0;
        return $collectionAttr . ($this->isAttrCommonOptions($collectionAttr) ? '_0' : "_" . $languageId);
    }

    public function getText2()
    {
        return $this->getText('text_2');
    }

    public function getText3()
    {
        return $this->getText('text_3');
    }

    public function getText4()
    {
        return $this->getText('text_4');
    }

    public function registerMetaTags()
    {
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->getMetaDescription()
        ]);

        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->getMetaKeyword()
        ]);
    }

    private function getMetaDescription()
    {
        return $this->getSeo('meta_des');
    }

    private function getSeo($seoAttr)
    {
        if (!($languageId = \Yii::$app->params['l'][\Yii::$app->language]))
            $languageId = 0;
        if (empty($this->seo_values))
            return null;
        return $this->seo_values[$seoAttr . '_' . $this->languageId];
    }

    private function getMetaKeyword()
    {
        return $this->getSeo('meta_keyword');
    }

    private function getMetaTitle()
    {
        return $this->getSeo('meta_title');
    }

    public function getLink(): string
    {
        return '/c/' . $this->collection->slug . '/' . $this->slug;
    }
}
