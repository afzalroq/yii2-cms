<?php

namespace afzalroq\cms\widgets\menu;

use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\Options;
use yii\bootstrap\Widget;

class MenuWidget extends Widget
{
    public function run()
    {
        $this->generate();
        return;
        return $this->render('_menu', [
            'menu' => $this->mapTree($this->convertToArray(Menu::find()->orderBy('sort')->indexBy('id')->all()))
        ]);
    }

    //    const TYPE_EMPTY = 1;
    //    const TYPE_ACTION = 2;
    //    const TYPE_LINK = 3;
    //    const TYPE_OPTION = 4;
    //    const TYPE_ITEM = 5;
    //    const TYPE_COLLECTION = 6;
    //    const TYPE_ENTITY = 7;
    //    const TYPE_ENTITY_ITEM = 10;

    private function generate()
    {
        $menus = Menu::find()->where(['>', 'depth', 0])->all();
        $prettyUrls = [];

        /** @var Menu $menu */

        foreach ($menus as $menu) {
            switch ($menu->type) {
                case Menu::TYPE_EMPTY:
                case Menu::TYPE_ACTION:
                case Menu::TYPE_LINK:
                    continue;
                case Menu::TYPE_OPTION:
                    $option = Options::findOne($menu->type_helper);
                        $prettyUrl = 'c/' . $option->collection->slug;
                    if ($option->collection->use_parenting)
                        $prettyUrl .= '/' . $this->nestedOptions($option);
                    $prettyUrls[] = 'c/' . $option->collection->slug . '/' . $option->slug;
            }
        }
    }

    private function nestedOptions($option)
    {

    }

    public function getMenuList()
    {
        return $this->mapTree($this->convertToArray(Menu::find()->orderBy('sort')->indexBy('id')->all()));
    }

    private function mapTree($dataset)
    {
        $tree = [];

        foreach ($dataset as $id => &$node) {
            if ($node['type'] == Menu::TYPE_ACTION) {
                $node['link'] = ('/' . rtrim($node['action'], '/'));
            } elseif ($node['type'] == Menu::TYPE_LINK) {
                $node['link'] = mb_strtolower($node['link']);
            } elseif ($node['type'] == Menu::TYPE_PAGE) {
                $node['link'] = '/page/' . $node['page_slug'];
            } elseif ($node['type'] == Menu::TYPE_ARTICLES_CATEGORY) {
                $node['link'] = '/blog/' . $node['articles_category_slug'];
            } else {
                $node['link'] = '#';
            }

            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    private function convertToArray($menuModels)
    {
        $menuArray = [];
        $array = [];

        foreach ($menuModels as $menu) {
            $array['id'] = $menu->id;
            $array['type'] = $menu->type;
            $array['parent_id'] = $menu->parent_id;
            $array['title_0'] = $menu->title_0;
            $array['title_1'] = $menu->title_1;
            $array['title_2'] = $menu->title_2;
            $array['title_3'] = $menu->title_3;
            switch ($menu->type) {
                case Menu::TYPE_ACTION:
                    $array['action'] = $menu->type_helper;
                    break;
                case Menu::TYPE_LINK:
                    $array['link'] = $menu->type_helper;
                    break;
                case Menu::TYPE_PAGE:
                    $array['page_slug'] = (Pages::findOne($menu->type_helper))->slug;
                    break;
                case Menu::TYPE_ARTICLES_CATEGORY:
                    $array['articles_category_slug'] = (ArticleCategories::findOne($menu->type_helper))->slug;
                    break;
            }

            $menuArray[$menu->id] = $array;
        }

        return $menuArray;
    }
}