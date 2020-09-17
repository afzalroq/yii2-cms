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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%abdualiym_cms_pages}}', [
            'id' => $this->primaryKey(),
            'title_0' => $this->string(),
            'title_1' => $this->string(),
            'title_2' => $this->string(),
            'title_3' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
            'content_0' => 'MEDIUMTEXT',
            'content_1' => ' MEDIUMTEXT',
            'content_2' => 'MEDIUMTEXT',
            'content_3' => 'MEDIUMTEXT',
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
