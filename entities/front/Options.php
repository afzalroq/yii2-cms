<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\interfaces\Linkable;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Options extends \afzalroq\cms\entities\Options implements Linkable
{

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

    private function getAttr($entityAttr)
    {
        if (!($languageId = Yii::$app->params['cms']['languageIds'][Yii::$app->language]))
            $languageId = 0;

        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $languageId);
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
        $filePath = $module->path . '/data/' . mb_strtolower(StringHelper::basename($this::className())) . '/' . $this->id . '/' . $this[$this->getAttr($collectionAttr)];
        return $module->host . str_replace($module->path, '', $filePath);
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
        if (!($languageId = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language]))
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

    public function getLink():string
    {
        return '/c/' . $this->collection->slug . '/' . $this->slug;
    }
}
