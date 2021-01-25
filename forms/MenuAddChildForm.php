<?php


namespace afzalroq\cms\forms;


use afzalroq\cms\entities\Menu;


class MenuAddChildForm extends \yii\base\Model
{
    public $child_id;

    public function rules()
    {
        return [
            ['child_id', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'child_id' => \Yii::t('cms', 'Child Menu')
        ];
    }


    public function getAvailableMenus($id)
    {
        Menu::find()->all();
    }

    public function getChildsList($id, $parent_id)
    {
        $list = [];
        $tree = $this->mapTrees($this->convert(Menu::find()->orderBy('sort')->indexBy('id')->all()));

        foreach ($tree as $item) {
            if ($item['id'] == $id || $item['id'] == $parent_id)
                continue;
            $list[$item['id']] = $item['title_0'];
        }

        return $list;
    }


    private function mapTrees($dataset)
    {
        $tree = [];

        foreach ($dataset as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    private function convert($menuModels)
    {
        $menuArray = [];
        $array = [];

        foreach ($menuModels as $menu) {
            $array['id'] = $menu->id;
            $array['parent_id'] = $menu->parent_id;
            $array['title_0'] = $menu->title_0;
            $menuArray[$menu->id] = $array;
        }

        return $menuArray;
    }

    public function getAvailableChilds($id)
    {
        return Menu::find()->all();
    }

    public function saveChild($id)
    {
        $menu = Menu::findOne($this->child_id);
        $menu->parent_id = $id;
        if ($menu->save())
            return true;

        return false;
    }
}