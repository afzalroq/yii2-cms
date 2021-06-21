<?php

use yii\db\Migration;

class m210507_132100_fixes extends Migration
{
    public function safeUp()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;

        #########################################################################################################
        $this->createTable('{{%cms_options_and_menu_types}}', [
            'id' => $this->primaryKey(),
            'option_id' => $this->integer()->notNull(),
            'menu_type_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-cms_options_and_menu_types_option_id', 'cms_options_and_menu_types', 'option_id');
        $this->addForeignKey('fkey-cms_options_and_menu_types_option_id', 'cms_options_and_menu_types', 'option_id', 'cms_options', 'id');

        $this->createIndex('index-cms_options_and_menu_types_menu_type_id', 'cms_options_and_menu_types', 'menu_type_id');
        $this->addForeignKey('fkey-cms_options_and_menu_types_menu_type_id', 'cms_options_and_menu_types', 'menu_type_id', 'cms_menu_type', 'id');


        #########################################################################################################
        $this->addColumn('cms_entities', 'disable_watermark', $this->tinyInteger());


        #########################################################################################################
        //cms options
        $this->addColumn('cms_options', 'created_by', $this->integer());
        $this->addColumn('cms_options', 'updated_by', $this->integer());
        //cms items
        $this->addColumn('cms_items', 'created_by', $this->integer());
        $this->addColumn('cms_items', 'updated_by', $this->integer());
        //cms menu
        $this->addColumn('cms_menu', 'created_by', $this->integer());
        $this->addColumn('cms_menu', 'updated_by', $this->integer());


        #########################################################################################################
        $this->renameColumn('cms_entities', 'disable_watermark', 'use_watermark');


        #########################################################################################################
        $this->renameColumn('cms_items', 'date', 'date_0');
        //adding columns to items
        $this->addColumn('cms_items', 'date_1', $this->integer()->unsigned());
        $this->addColumn('cms_items', 'date_2', $this->integer()->unsigned());
        $this->addColumn('cms_items', 'date_3', $this->integer()->unsigned());
        $this->addColumn('cms_items', 'date_4', $this->integer()->unsigned());


        #########################################################################################################
        $this->dropForeignKey('fkey-cms_options_and_items-option_id', 'cms_options_and_items');
        $this->addForeignKey('fkey-cms_options_and_items-option_id', 'cms_options_and_items', 'option_id', 'cms_options', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('fkey-cms_options_and_items-item_id', 'cms_options_and_items');
        $this->addForeignKey('fkey-cms_options_and_items-item_id', 'cms_options_and_items', 'item_id', 'cms_items', 'id', 'CASCADE', 'CASCADE');

        $this->alterColumn('cms_entities', 'use_watermark', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('cms_entities', 'disable_create_and_delete', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('cms_entities', 'use_views_count', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('cms_items', 'views_count', $this->integer()->notNull()->defaultValue(0));

        $this->alterColumn('cms_entities', 'use_gallery', $this->tinyInteger()->defaultValue(0));

        $this->dropForeignKey('fkey-cms_collections_and_entities-collection_id', 'cms_collections_and_entities');
        $this->addForeignKey('fkey-cms_collections_and_entities-collection_id', 'cms_collections_and_entities', 'collection_id', 'cms_collections', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('fkey-cms_collections_and_entities-entities_id', 'cms_collections_and_entities');
        $this->addForeignKey('fkey-cms_collections_and_entities-entities_id', 'cms_collections_and_entities', 'entity_id', 'cms_entities', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_options_and_items}}');
    }
}
