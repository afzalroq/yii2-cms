<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_collections_and_entities}}`.
 */
class m201218_061950_create_collections_and_entities_table extends Migration
{
	public function safeUp()
	{
        $tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;

		$this->createTable('{{%cms_collections_and_entities}}', [
			'id' => $this->primaryKey(),
			'collection_id' => $this->integer(),
			'entity_id' => $this->integer(),
			'type' => $this->tinyInteger(),
			'sort' => $this->integer()->notNull()->defaultValue(1),
			'size' => $this->tinyInteger(),
			'created_at' => $this->integer()->unsigned()->notNull(),
			'updated_at' => $this->integer()->unsigned()->notNull(),
		], $tableOptions);

        $this->createIndex('index-cms_collections_and_entities-collection_id', 'cms_collections_and_entities', 'collection_id');
        $this->addForeignKey('fkey-cms_collections_and_entities-collection_id', 'cms_collections_and_entities', 'collection_id', 'cms_collections', 'id');

        $this->createIndex('index-cms_collections_and_entities-entities_id', 'cms_collections_and_entities', 'entity_id');
        $this->addForeignKey('fkey-cms_collections_and_entities-entities_id', 'cms_collections_and_entities', 'entity_id', 'cms_entities', 'id');
	}

	public function safeDown()
	{
		$this->dropTable('{{%cms_collections_and_entities}}');
	}
}
