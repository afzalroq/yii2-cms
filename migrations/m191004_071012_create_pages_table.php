nn         <?php

use yii\db\Migration;

/**
 * Handles the creation of table `abdualiym_cms_pages`.
 */
class m191004_071012_create_pages_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : null;
		$textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

		$this->createTable('{{%abdualiym_cms_pages}}', [
			'id' => $this->primaryKey(),
			'title_0' => $this->string(),
			'title_1' => $this->string(),
			'title_2' => $this->string(),
			'title_3' => $this->string(),
			'slug' => $this->string()->notNull()->unique(),
			'content_0' => $textType,
			'content_1' => $textType,
			'content_2' => $textType,
			'content_3' => $textType,
			'created_at' => $this->integer()->unsigned()->notNull(),
			'updated_at' => $this->integer()->unsigned()->notNull(),
		], $tableOptions);

		$this->createIndex('index-abdualiym_cms_pages-slug', 'abdualiym_cms_pages', 'slug');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('abdualiym_cms_pages');
	}
}
