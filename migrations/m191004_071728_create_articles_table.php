<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m191004_071728_create_articles_table extends Migration
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

        $this->createTable('{{%abdualiym_cms_articles}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title_0' => $this->string(),
            'title_1' => $this->string(),
            'title_2' => $this->string(),
            'title_3' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
            'content_0' => 'MEDIUMTEXT',
            'content_1' => 'MEDIUMTEXT',
            'content_2' => 'MEDIUMTEXT',
            'content_3' => 'MEDIUMTEXT',
            'date' => $this->integer()->unsigned(),
            'photo' => $this->string(),
            'status' => $this->tinyInteger()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-abdualiym_cms_articles-slug', 'abdualiym_cms_articles', 'slug', true);
        $this->createIndex('index-abdualiym_cms_articles-status', 'abdualiym_cms_articles', 'status');

        $this->createIndex('index-abdualiym_cms_articles-category_id', 'abdualiym_cms_articles', 'category_id');
        $this->addForeignKey('fkey-abdualiym_cms_articles-category_id', 'abdualiym_cms_articles', 'category_id', 'abdualiym_cms_article_categories', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('abdualiym_cms_articles');
    }
}
