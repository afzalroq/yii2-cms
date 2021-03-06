<?php

use yii\db\Migration;

/**
 * Class m200305_121443_create_unit_units_table
 */
class m200305_121443_create_unit_units_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cms_unit_units}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'sort' => $this->tinyInteger()->notNull(),
            'slug' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
            'size' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'inputValidator' => $this->integer()->defaultValue(1),
            'data_0' => $this->text(),
            'data_1' => $this->text(),
            'data_2' => $this->text(),
            'data_3' => $this->text(),
            'data_4' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-cms_unit_units-slug}}', '{{%cms_unit_units}}', 'slug');
        $this->createIndex('{{%index-cms_unit_units-updated_at}}', '{{%cms_unit_units}}', 'updated_at');

        $this->createIndex('index-cms_unit_units-category_id', 'cms_unit_units', 'category_id');
        $this->addForeignKey('fkey-cms_unit_units-category_id', 'cms_unit_units', 'category_id', 'cms_unit_categories', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('cms_unit_units');
    }

}
