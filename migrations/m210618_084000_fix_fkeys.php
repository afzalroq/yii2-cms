<?php

use yii\db\Migration;

class m210618_084000_fix_fkeys extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fkey-cms_menu-menu_type_id', 'cms_menu');
        $this->addForeignKey('fkey-cms_menu-menu_type_id', 'cms_menu', 'menu_type_id', 'cms_menu_type', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('fkey-cms_options_and_menu_types_option_id', 'cms_options_and_menu_types');
        $this->addForeignKey('fkey-cms_options_and_menu_types_option_id', 'cms_options_and_menu_types', 'option_id', 'cms_options', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('fkey-cms_options_and_menu_types_menu_type_id', 'cms_options_and_menu_types');
        $this->addForeignKey('fkey-cms_options_and_menu_types_menu_type_id', 'cms_options_and_menu_types', 'menu_type_id', 'cms_menu_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_options_and_items}}');
    }
}
