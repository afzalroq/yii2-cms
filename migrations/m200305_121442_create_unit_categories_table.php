<?php

use yii\db\Migration;


class m200305_121442_create_unit_categories_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cms_unit_categories}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull()->unique(),
            'title' => $this->string(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('index-cms_unit_categories-slug', 'cms_unit_categories', 'slug', true);
    }

    public function safeDown()
    {
        $this->dropTable('cms_unit_categories');
    }

}
