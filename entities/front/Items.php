<?php

namespace afzalroq\cms\entities\front;

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\ItemComments;
use afzalroq\cms\entities\OaI;
use afzalroq\cms\interfaces\Linkable;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;

class Items extends \afzalroq\cms\entities\Items
{

    public static function getAll($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findAll(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, $cacheDuration, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public static function get($slug)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('items_' . $slug, function () use ($slug) {

            return self::findOne(['entity_id' => Entities::findOne(['slug' => $slug])->id]);

        }, $cacheDuration, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public static function getWithOptions($slug, array $orderBy = null, $limit = null, $status = null)
    {
        $cache = Yii::$app->getModule('cms')->cache;
        $cacheDuration = Yii::$app->getModule('cms')->cacheDuration;
        return \Yii::$app->{$cache}->getOrSet('items_' . $slug . $orderBy ?? $orderBy . $limit ?? $limit . $status ?? $status, function () use ($slug, $orderBy, $limit, $status) {
            $query = self::find()->where(['entity_id' => Entities::findOne(['slug' => $slug])->id]);
            if ($orderBy)
                $query->orderBy($orderBy);
            if ($status)
                $query->where(['status' => $status]);
            if ($limit)
                $query->limit($limit);
            return $query->all();

        }, $cacheDuration, new TagDependency(['tags' => ['items_' . $slug]]));
    }

    public static function searchByEntityQuery(array $entitySlugs, $search)
    {
        $langId = Yii::$app->params['l'][Yii::$app->language];
        $entityId = Entities::find()->where(['slug' => $entitySlugs])->select('id')->column();
        $query = Items::find()->where(['entity_id' => $entityId]);
        return $query->andFilterWhere(['or',
            ['like', 'text_1_' . $langId, $search],
            ['like', 'text_2_' . $langId, $search],
            ['like', 'text_3_' . $langId, $search],
            ['like', 'text_4_' . $langId, $search],
            ['like', 'text_5_' . $langId, $search],
            ['like', 'text_6_' . $langId, $search],
            ['like', 'text_7_' . $langId, $search],
        ]);
    }

    public static function searchByOptionsQuery(array $optionSlugs, $search)
    {
        $langId = Yii::$app->params['l'][Yii::$app->language];
        $optionId = Options::find()->where(['slug' => $optionSlugs])->select('id')->column();
        $OaI = OaI::find()->where(['option_id' => $optionId])->select('item_id')->column();
        $query = Items::find()->where(['id' => $OaI]);
        return $query->andFilterWhere(['or',
            ['like', 'text_1_' . $langId, $search],
            ['like', 'text_2_' . $langId, $search],
            ['like', 'text_3_' . $langId, $search],
            ['like', 'text_4_' . $langId, $search],
            ['like', 'text_5_' . $langId, $search],
            ['like', 'text_6_' . $langId, $search],
            ['like', 'text_7_' . $langId, $search],
        ]);
    }

    public function getText1()
    {
        return $this->getText('text_1');
    }

    private function getText($entityAttr)
    {
        return $this[$this->getAttr($entityAttr)];
    }

    private function getAttr($entityAttr)
    {
        if (!($languageId = \Yii::$app->params['l'][\Yii::$app->language]))
            $languageId = 0;

        return $entityAttr . ($this->isAttrCommon($entityAttr) ? '_0' : "_" . $languageId);
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

    public function getText5()
    {
        return $this->getText('text_5');
    }

    public function getText6()
    {
        return $this->getText('text_6');
    }

    public function getText7()
    {
        return $this->getText('text_7');
    }

    public function registerMetaTags()
    {
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => strip_tags($this->getMetaDescription() ?: $this->text2)
        ]);

        \Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'article'
        ]);

        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $this->text1
        ]);

        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => strip_tags($this->getMetaDescription() ?: $this->text2)
        ]);

        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->getUrlManager()->createAbsoluteUrl($this->link)
        ]);

        $imageUrl = \Yii::$app->getModule('cms')->watermark ?: \Yii::$app->getModule('cms')->fallback;
        if (FileType::hasImage($this->entity)) {
            $w = $w0 = $this->entity['file_1_dimensionW'];
            $h = $h0 = $this->entity['file_1_dimensionH'];
            if ($w0 > 640) {
                $diff = $w0 / 640;
                $w = 640;
                $h = $h0 / $diff;
            }
            if ($this->entity->use_gallery) {
                if ($this->mainPhoto) {
                    $imageUrl = $this->mainPhoto->getPhoto($w, $h);
                } elseif ($this->file_1_0) {
                    $imageUrl = $this->getImageUrl('file_1_0', $w, $h);
                }
            } elseif ($this->file_1_0) {
                $imageUrl = $this->getImageUrl('file_1_0', $w, $h);
            }
        }

        \Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'content' => $imageUrl
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

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto1($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_1', $width, $height, $operation, $background, $xPos, $yPos);
    }

    private function getPhoto($entityAttr, $width, $height, $operation, $background, $xPos, $yPos)
    {
        return $this->getImageUrl($this->getAttr($entityAttr), $width, $height, $operation, $background, $xPos, $yPos);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto2($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_2', $width, $height, $operation, $background, $xPos, $yPos);
    }

    /**
     * https://github.com/Gregwar/Image#usage
     */
    public function getPhoto3($width = null, $height = null, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return $this->getPhoto('file_3', $width, $height, $operation, $background, $xPos, $yPos);
    }

    public function getFile1()
    {
        return $this->getFile('file_1');
    }

    private function getFile($entityAttr)
    {
        $module = Yii::$app->getModule('cms');
        $filePath = 'data/' . mb_strtolower(StringHelper::basename($this::className())) . '/' . $this->id . '/' . $this[$this->getAttr($entityAttr)];
        return $module->host . $filePath;
    }

    public function getFile2()
    {
        return $this->getFile('file_2');
    }

    public function getFile3()
    {
        return $this->getFile('file_3');
    }

    private function getMetaTitle()
    {
        return $this->getSeo('meta_title');
    }

    public function updateViewsCount()
    {
        $session = Yii::$app->session;
        $items = $session->get('session_items', []);
        if (!isset($items[$this->id])) {
            $items += [$this->id => true];
            $session->set('session_items', $items);
            $this->views_count++;
            $this->detachBehaviors();
            $this->save();
        }
    }

    public function getComments()
    {
        return new \yii\data\ActiveDataProvider([
            'query' => ItemComments::find()->where(['item_id' => $this->id, 'status' => ItemComments::STATUS_CHECKED]),
            'pagination' => false
        ]);
    }
}
