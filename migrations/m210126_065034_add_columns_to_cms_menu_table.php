<?php

use yii\db\Migration;

/**
 * Class m210126_065034_addas
 */
class m210126_065034_add_columns_to_cms_menu_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('cms_menu', 'tree', $this->integer()->notNull());
        $this->addColumn('cms_menu', 'lft', $this->integer()->notNull());
        $this->addColumn('cms_menu', 'rgt', $this->integer()->notNull());
        $this->addColumn('cms_menu', 'depth', $this->integer()->notNull());
        $this->addColumn('cms_menu', 'name', $this->string());
//        $this->insert('cms_menu', [
//            'id' => 1,
//            'title_0' => 'Root',
//            'type' => 1,
//            'type_helper' => '1',
//            'tree' => 1,
//            'lft' => 1,
//            'rgt' => 2,
//            'depth' => 0,
//            'created_at' => time(),
//            'updated_at' => time(),
//        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cms_menu', 'tree');
        $this->dropColumn('cms_menu', 'lft');
        $this->dropColumn('cms_menu', 'rgt');
        $this->dropColumn('cms_menu', 'depth');
        $this->dropColumn('cms_menu', 'name');
    }
}
