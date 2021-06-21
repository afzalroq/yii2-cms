<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_item_photos}}`.
 */
class m201212_036644_create_item_photos_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;
        $textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

        $this->createTable('{{%cms_item_photos}}', [
            'id' => $this->primaryKey(),
            'cms_item_id' => $this->integer(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_item_photos}}');
    }
}
