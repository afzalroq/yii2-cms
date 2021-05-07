<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_collections}}`.
 */
class m201207_131825_create_collections_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cms_collections}}', [
            'id' => $this->primaryKey(),
            'name_0' => $this->string(),
            'name_1' => $this->string(),
            'name_2' => $this->string(),
            'name_3' => $this->string(),
            'name_4' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
	        'use_in_menu' => $this->tinyInteger()->notNull(),
	        'use_seo' => $this->tinyInteger(),
	        'use_parenting' => $this->tinyInteger(),
	        'option_name' => $this->tinyInteger(),
	        'option_content' => $this->tinyInteger(),
	        'option_file_1' => $this->tinyInteger(),
	        'option_file_2' => $this->tinyInteger(),
	        'option_file_1_label' => $this->string(),
	        'option_file_2_label' => $this->string(),
	        'option_file_1_validator' => $this->json(),
	        'option_file_2_validator' => $this->json(),
	        'option_default_id' => $this->integer(),
	        'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-cms_collections-slug', 'cms_collections', 'slug', true);
        $this->createIndex('index-cms_collections-option_default_id', 'cms_collections', 'option_default_id');
    }


    public function safeDown()
    {
        $this->dropTable('{{%cms_collections}}');
    }
}
