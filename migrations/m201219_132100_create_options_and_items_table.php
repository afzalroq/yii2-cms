<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_options_and_items}}`.
 */
class m201219_132100_create_options_and_items_table extends Migration
{
	public function safeUp()
	{
        $tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;

        $this->createTable('{{%cms_options_and_items}}', [
			'option_id' => $this->integer()->notNull(),
			'item_id' => $this->integer()->notNull()
		], $tableOptions);

		$this->createIndex('index-cms_options_and_items-option_id', 'cms_options_and_items', 'option_id');
        $this->addForeignKey('fkey-cms_options_and_items-option_id', 'cms_options_and_items', 'option_id', 'cms_options', 'id');

        $this->createIndex('index-cms_options_and_items-item_id', 'cms_options_and_items', 'item_id');
		$this->addForeignKey('fkey-cms_options_and_items-item_id', 'cms_options_and_items', 'item_id', 'cms_items', 'id');
	}

	public function safeDown()
	{
		$this->dropTable('{{%cms_options_and_items}}');
	}
}
