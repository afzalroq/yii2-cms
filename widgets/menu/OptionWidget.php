<?php

namespace afzalroq\cms\widgets\menu;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\front\Options;
use slatiusa\nestable\Nestable;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class OptionWidget extends Nestable
{
    private $_uniqueItems = [];

    public function registerAssets()
    {
        return '';
    }

    public function run()
    {
        return '';
    }

    public function getMenu($slug = null)
    {
        if ($collection = Collections::findOne(['slug' => $slug]))
            return $this->prepareItems(Options::find()->where(['collection_id' => $collection->id])->orderBy('id'));

        throw new UnknownPropertyException(Yii::t('cms', 'Collection not found') . ' : ' . $slug);
    }

    protected function prepareItems($activeQuery): array
    {
        $langId = Yii::$app->params['l'][Yii::$app->language];
        $items = [];
        foreach ($activeQuery->all() as $model) {
            if (in_array($model->id, $this->_uniqueItems)) {
                continue;
            } else {
                $this->_uniqueItems[] = $model->id;
                $name = ArrayHelper::getValue($this->modelOptions, 'name_' . $langId, 'name_' . $langId);
                $content = ArrayHelper::getValue($this->modelOptions, 'content_' . $langId, 'content_' . $langId);
                $items[] = [
                    'id' => $model->getPrimaryKey(),
                    'name' => (is_callable($name) ? call_user_func($name, $model) : $model->{$name}),
                    'content' => (is_callable($content) ? call_user_func($content, $model) : $model->{$content}),
                    'link' => $model->getLink(),
                    'children' => $this->prepareItems($model->children(1)),
                ];
            }
        }
        return $items;
    }

    protected function renderItems($_items = NULL)
    {
        return '';
    }
}
