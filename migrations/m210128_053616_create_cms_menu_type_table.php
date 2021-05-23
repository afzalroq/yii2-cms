<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_menu_type}}`.
 */
class m210128_053616_create_cms_menu_type_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%cms_menu_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull()->unique(),
            'name_0' => $this->string(),
            'name_1' => $this->string(),
            'name_2' => $this->string(),
            'name_3' => $this->string(),
            'name_4' => $this->string(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addColumn('cms_menu', 'menu_type_id', $this->integer()->notNull());
        $this->createIndex('idx-cms_menu-menu_typ_id', 'cms_menu', 'menu_type_id');
        $this->addForeignKey('fkey-cms_menu-menu_type_id', 'cms_menu', 'menu_type_id', 'cms_menu_type', 'id');

        $this->createIndex('index-cms_collections-slug', 'cms_menu_type', 'slug', true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_menu_type}}');
        $this->dropForeignKey('fkey-cms_menu-menu_type_id', 'cms_menu');
        $this->dropIndex('idx-cms_menu-menu_typ_id', 'cms_menu');
        $this->dropColumn('cms_menu', 'menu_type_id');
    }
}
