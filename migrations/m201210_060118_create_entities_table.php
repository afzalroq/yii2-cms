<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_entities}}`.
 */
class m201210_060118_create_entities_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cms_entities}}', [
            'id' => $this->primaryKey(),
            'name_0' => $this->string(),
            'name_1' => $this->string(),
            'name_2' => $this->string(),
            'name_3' => $this->string(),
            'name_4' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
            'text_1' => $this->tinyInteger(),
            'text_2' => $this->tinyInteger(),
            'text_3' => $this->tinyInteger(),
            'text_4' => $this->tinyInteger(),
            'text_5' => $this->tinyInteger(),
            'text_6' => $this->tinyInteger(),
            'text_7' => $this->tinyInteger(),
            'text_1_label' => $this->string(),
            'text_2_label' => $this->string(),
            'text_3_label' => $this->string(),
            'text_4_label' => $this->string(),
            'text_5_label' => $this->string(),
            'text_6_label' => $this->string(),
            'text_7_label' => $this->string(),
            'file_1' => $this->tinyInteger(),
            'file_2' => $this->tinyInteger(),
            'file_3' => $this->tinyInteger(),
            'file_1_label' => $this->string(),
            'file_2_label' => $this->string(),
            'file_3_label' => $this->string(),
            'file_1_validator' => $this->json(),
            'file_2_validator' => $this->json(),
            'file_3_validator' => $this->json(),
            'use_date' => $this->tinyInteger(),
            'use_status' => $this->tinyInteger(),
            'use_galery' => $this->tinyInteger(),
            'use_in_menu' => $this->tinyInteger(),
            'use_seo' => $this->tinyInteger(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'index-cms_entities-slug',
            'cms_entities',
            'slug',
            true
        );

    }


    public function safeDown()
    {
        $this->dropTable('{{%cms_entities}}');
    }
}
