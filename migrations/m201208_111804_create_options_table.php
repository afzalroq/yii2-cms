<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_options}}`.
 */
class m201208_111804_create_options_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;
        $textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

        $this->createTable('{{%cms_options}}', [
            'id' => $this->primaryKey(),
            'collection_id' => $this->integer()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'name_0' => $this->string(),
            'name_1' => $this->string(),
            'name_2' => $this->string(),
            'name_3' => $this->string(),
            'name_4' => $this->string(),
            'content_0' => $textType,
            'content_1' => $textType,
            'content_2' => $textType,
            'content_3' => $textType,
            'content_4' => $textType,
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
            'seo_values' => $this->json(),
            'sort' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-cms_options-slug', 'cms_options', 'slug', true);

        $this->createIndex('index-cms_options-collection_id', 'cms_options', 'collection_id');
        $this->addForeignKey('fkey-cms_options-collection_id', 'cms_options', 'collection_id', 'cms_collections', 'id');

        $this->addForeignKey('fkey-cms_collections-option_default_id', 'cms_collections', 'option_default_id', 'cms_options', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_options}}');
    }
}
