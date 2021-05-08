<?php

use yii\db\Migration;

class m210507_132100_fixes extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fkey-cms_options_and_items-option_id', 'cms_options_and_items');
        $this->addForeignKey('fkey-cms_options_and_items-option_id', 'cms_options_and_items', 'option_id', 'cms_options', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('fkey-cms_options_and_items-item_id', 'cms_options_and_items');
        $this->addForeignKey('fkey-cms_options_and_items-item_id', 'cms_options_and_items', 'item_id', 'cms_items', 'id', 'CASCADE', 'CASCADE');

        $this->alterColumn('cms_entities', 'use_watermark', $this->tinyInteger()->defaultValue(0)->notNull());
        $this->alterColumn('cms_entities', 'disable_create_and_delete', $this->tinyInteger()->defaultValue(0)->notNull());
        $this->alterColumn('cms_collections', 'manual_slug', $this->tinyInteger()->defaultValue(0)->notNull());

        $this->alterColumn('cms_entities', 'manual_slug', $this->tinyInteger()->defaultValue(0)->notNull());
        $this->alterColumn('cms_entities', 'use_views_count', $this->tinyInteger()->defaultValue(0)->notNull());
        $this->alterColumn('cms_items', 'views_count', $this->integer()->notNull()->defaultValue(0));

        $this->alterColumn('cms_entities', 'use_gallery', $this->tinyInteger()->notNull()->defaultValue(0));

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
