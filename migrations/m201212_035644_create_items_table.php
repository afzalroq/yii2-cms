<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_items}}`.
 */
class m201212_035644_create_items_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : null;
		$textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

		$this->createTable('{{%cms_items}}', [
			'id' => $this->primaryKey(),
			'entity_id' => $this->integer()->notNull(),
			'slug' => $this->string()->notNull()->unique(),
			'text_1_0' => $textType,
			'text_1_1' => $textType,
			'text_1_2' => $textType,
			'text_1_3' => $textType,
			'text_1_4' => $textType,
			'text_2_0' => $textType,
			'text_2_1' => $textType,
			'text_2_2' => $textType,
			'text_2_3' => $textType,
			'text_2_4' => $textType,
			'text_3_0' => $textType,
			'text_3_1' => $textType,
			'text_3_2' => $textType,
			'text_3_3' => $textType,
			'text_3_4' => $textType,
			'text_4_0' => $textType,
			'text_4_1' => $textType,
			'text_4_2' => $textType,
			'text_4_3' => $textType,
			'text_4_4' => $textType,
			'text_5_0' => $textType,
			'text_5_1' => $textType,
			'text_5_2' => $textType,
			'text_5_3' => $textType,
			'text_5_4' => $textType,
			'text_6_0' => $textType,
			'text_6_1' => $textType,
			'text_6_2' => $textType,
			'text_6_3' => $textType,
			'text_6_4' => $textType,
			'text_7_0' => $textType,
			'text_7_1' => $textType,
			'text_7_2' => $textType,
			'text_7_3' => $textType,
			'text_7_4' => $textType,

			'file_1_0' => $this->string(),
			'file_1_1' => $this->string(),
			'file_1_2' => $this->string(),
			'file_1_3' => $this->string(),
			'file_1_4' => $this->string(),
			'file_2_0' => $this->string(),
			'file_2_1' => $this->string(),
			'file_2_2' => $this->string(),
			'file_2_3' => $this->string(),
			'file_2_4' => $this->string(),
			'file_3_0' => $this->string(),
			'file_3_1' => $this->string(),
			'file_3_2' => $this->string(),
			'file_3_3' => $this->string(),
			'file_3_4' => $this->string(),

			'date' => $this->integer()->unsigned(),
			'status' => $this->tinyInteger(),
			'created_at' => $this->integer()->unsigned()->notNull(),
			'updated_at' => $this->integer()->unsigned()->notNull(),
		], $tableOptions);

		$this->createIndex(
			'index-cms_items-slug',
			'cms_items',
			'slug',
			true
		);
		$this->createIndex(
			'index-cms_items-entity_id',
			'cms_items',
			'entity_id'
		);

		$this->addForeignKey(
			'fkey-cms_items-entity_id',
			'cms_items',
			'entity_id',
			'cms_entities',
			'id'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%cms_items}}');
	}
}
