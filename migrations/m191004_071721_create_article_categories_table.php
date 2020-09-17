<?php

use yii\db\Migration;

/**
 * Handles the creation of table `abdualiym_cms_article_categories`.
 */
class m191004_071721_create_article_categories_table extends Migration
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

        $this->createTable('{{%abdualiym_cms_article_categories}}', [
            'id' => $this->primaryKey(),
            'title_0' => $this->string(),
            'title_1' => $this->string(),
            'title_2' => $this->string(),
            'title_3' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
            'description_0' => $this->text(),
            'description_1' => $this->text(),
            'description_2' => $this->text(),
            'description_3' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-abdualiym_cms_article_categories-slug', 'abdualiym_cms_article_categories', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abdualiym_cms_article_categories');
    }
}
