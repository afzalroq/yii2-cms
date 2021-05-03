<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_options_and_items}}`.
 */
class m211219_176100_create_options_and_menu_types_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%cms_options_and_menu_types}}', [
            'id' => $this->primaryKey(),
			'option_id' => $this->integer()->notNull(),
			'menu_type_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
		]);

		$this->createIndex(
			'index-cms_options_and_menu_types_option_id',
			'cms_options_and_menu_types',
			'option_id'
		);

		$this->createIndex(
			'index-cms_options_and_menu_types_menu_type_id',
			'cms_options_and_menu_types',
			'menu_type_id'
		);

		$this->addForeignKey(
			'fkey-cms_options_and_menu_types_option_id',
			'cms_options_and_menu_types',
			'option_id',
			'cms_options',
			'id');

		$this->addForeignKey(
			'fkey-cms_options_and_menu_types_menu_type_id',
			'cms_options_and_menu_types',
			'menu_type_id',
			'cms_menu_type',
			'id');
	}

	public function safeDown()
	{
		$this->dropTable('{{%cms_options_and_menu_types}}');
	}
}
