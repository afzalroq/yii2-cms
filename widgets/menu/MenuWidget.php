<?php

namespace afzalroq\cms\widgets\menu;

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Items;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use afzalroq\cms\entities\Options;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;


class MenuWidget
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
        if (MenuType::findOne(['slug' => $slug]))
            return $this->prepareItems(Menu::find()->where(['menu_type_id' => MenuType::findOne(['slug' => $slug])->id])->orderBy('id'));

        throw new UnknownPropertyException(Yii::t('cms', 'Menu type not found') . ' : ' . $slug);
    }

    protected function prepareItems($activeQuery): array
    {
        $langId = Yii::$app->params['cms']['languageIds'][Yii::$app->language];
        $items = [];
        foreach ($activeQuery->all() as $model) {
            if (in_array($model->id, $this->_uniqueItems)) {
                continue;
            } else {
                $this->_uniqueItems[] = $model->id;
                $name = ArrayHelper::getValue($this->modelOptions, 'title_' . $langId, 'title_' . $langId);
                $items[] = [
                    'id' => $model->getPrimaryKey(),
                    'content' => (is_callable($name) ? call_user_func($name, $model) : $model->{$name}),
                    'link' => $this->getLink($model),
                    'children' => $this->prepareItems($model->children(1)),
                ];
            }
        }
        return $items;
    }

    private static function getLink($model)
    {
        switch ($model->type) {
            case Menu::TYPE_ACTION:
                return '/' . rtrim($model->type_helper, '/');
                break;
            case Menu::TYPE_LINK:
                return mb_strtolower($model->type_helper);
                break;
            case Menu::TYPE_COLLECTION:
                return Collections::findOne($model->type_helper)->link;
                break;
            case Menu::TYPE_OPTION:
                return \afzalroq\cms\entities\front\Options::findOne($model->type_helper) ? \afzalroq\cms\entities\front\Options::findOne($model->type_helper)->link : "";
                break;
            case Menu::TYPE_ENTITY:
                return Entities::findOne($model->type_helper)->link;
                break;
            case Menu::TYPE_ITEM:
            case Menu::TYPE_ENTITY_ITEM:
                return \afzalroq\cms\entities\front\Items::findOne($model->type_helper) ? \afzalroq\cms\entities\front\Items::findOne($model->type_helper)->link : "";
                break;
            default:
                return '#';
        }
    }

    protected function renderItems($_items = NULL)
    {
        return '';
    }
}
