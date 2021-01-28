<?php

namespace afzalroq\cms\widgets\menu;

use slatiusa\nestable\Nestable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class CmsNestable extends Nestable
{
    private $_uniqueItems = [];

    private function getItemLink($item): string
    {
        $text = ArrayHelper::getValue($item, 'content', '');
        $url_view = Url::to(['/cms/menu/view', 'id' => ArrayHelper::getValue($item, 'id')]);
        $url_update = Url::to(['/cms/menu/update', 'id' => ArrayHelper::getValue($item, 'id')]);
        $url_add_child = Url::to(['/cms/menu/add-child', 'root_id' => ArrayHelper::getValue($item, 'id')]);

        $return_text = Html::a($text, $url_view);
        $return_text .= Html::a('<i class="fa fa-plus"></i>', $url_add_child, ['class' => 'pull-right', 'style' => 'margin-left: 15px']);
        $return_text .= Html::a('<i class="fa fa-pencil"></i>', $url_update, ['class' => 'pull-right', 'style' => 'margin-left: 15px']);

        return $return_text;
    }

    protected function renderItems($_items = NULL): string
    {
        $_items = is_null($_items) ? $this->items : $_items;
        $items = '';
        $data_id = 0;
        foreach ($_items as $item) {
            $options = ArrayHelper::getValue($item, 'options', ['class' => 'dd-item dd3-item']);
            $options = ArrayHelper::merge($this->itemOptions, $options);
            $dataId = ArrayHelper::getValue($item, 'id', $data_id++);
            $options = ArrayHelper::merge($options, ['data-id' => $dataId]);

            $contentOptions = ArrayHelper::getValue($item, 'contentOptions', ['class' => 'dd3-content']);
            $content = $this->handleLabel;
            $content .= Html::tag('div', $this->getItemLink($item), $contentOptions);

            $children = ArrayHelper::getValue($item, 'children', []);
            if (!empty($children)) {
                // recursive rendering children items
                $content .= Html::beginTag('ol', ['class' => 'dd-list']);
                $content .= $this->renderItems($children);
                $content .= Html::endTag('ol');
            }

            $items .= Html::tag('li', $content, $options) . PHP_EOL;
        }
        return $items;
    }

    protected function prepareItems($activeQuery): array
    {
        $items = [];
        foreach ($activeQuery->all() as $model) {
            if (in_array($model->id, $this->_uniqueItems)) {
                continue;
            } else {
                $this->_uniqueItems[] = $model->id;
                $name = ArrayHelper::getValue($this->modelOptions, 'name', 'name');
                $items[] = [
                    'id' => $model->getPrimaryKey(),
                    'content' => (is_callable($name) ? call_user_func($name, $model) : $model->{$name}),
                    'children' => $this->prepareItems($model->children(1)),
                ];
            }
        }
        return $items;
    }
}