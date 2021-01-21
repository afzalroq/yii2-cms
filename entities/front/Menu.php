<?php

namespace afzalroq\cms\entities\front;

class Menu extends \afzalroq\cms\entities\Menu
{


    public function getMenu()
    {
        $menu = $this->convertToArray(self::find()->orderBy('sort')->indexBy('id')->all());

        $menuTree = [];

        foreach ($menu as $id => &$node) {
            if ($node['parent_id']) {
                $menu[$node['parent_id']]['childs'][$id] = &$node;
            } else {
                $menuTree[$id] = &$node;
            }
        }

        return $menuTree;
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
            $array['title_4'] = $menu->title_4;
            switch ($menu->type) {
                case self::TYPE_ACTION:
                    $array['link'] = '/' . rtrim($menu->type_helper, '/');
                    break;
                case self::TYPE_LINK:
                    $array['link'] = mb_strtolower($menu->type_helper);
                    break;
//                case Menu::TYPE_PAGE:
//                    $array['page_slug'] = '/page/' . (Pages::findOne($menu->type_helper))->slug;
//                    break;
                case self::TYPE_OPTION:
                    $array['option_id'] = $menu->type_helper;
                    break;
                case self::TYPE_ITEM:
                    $array['item_id'] = $menu->type_helper;
                    break;
                case self::TYPE_ENTITY_ITEM:
                    $array['entity_id'] = $menu->type_helper;
                    break;
//                case Menu::TYPE_ARTICLES_CATEGORY:
//                    $array['articles_category_slug'] = '/blog/' . (ArticleCategories::findOne($menu->type_helper))->slug;
//                    break;
            }

            $menuArray[$menu->id] = $array;
        }

        return $menuArray;
    }
}
