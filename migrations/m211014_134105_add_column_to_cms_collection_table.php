<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_collection}}`.
 */
class m211014_134105_add_column_to_cms_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cms_collections}}', 'text_1', $this->tinyInteger());
        $this->addColumn('{{%cms_collections}}', 'text_2', $this->tinyInteger());
        $this->addColumn('{{%cms_collections}}', 'text_3', $this->tinyInteger());
        $this->addColumn('{{%cms_collections}}', 'text_4', $this->tinyInteger());
        $this->addColumn('{{%cms_collections}}', 'text_1_label', $this->string());
        $this->addColumn('{{%cms_collections}}', 'text_2_label', $this->string());
        $this->addColumn('{{%cms_collections}}', 'text_3_label', $this->string());
        $this->addColumn('{{%cms_collections}}', 'text_4_label', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cms_collections}}', 'text_1', $this->tinyInteger());
        $this->dropColumn('{{%cms_collections}}', 'text_2', $this->tinyInteger());
        $this->dropColumn('{{%cms_collections}}', 'text_3', $this->tinyInteger());
        $this->dropColumn('{{%cms_collections}}', 'text_4', $this->tinyInteger());
        $this->dropColumn('{{%cms_collections}}', 'text_1_label', $this->string());
        $this->dropColumn('{{%cms_collections}}', 'text_2_label', $this->string());
        $this->dropColumn('{{%cms_collections}}', 'text_3_label', $this->string());
        $this->dropColumn('{{%cms_collections}}', 'text_4_label', $this->string());
    }
}
