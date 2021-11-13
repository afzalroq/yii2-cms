<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_collections_and_entities}}`.
 */
class m211106_134754_add_column_to_cms_collection_and_entities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cms_collections_and_entities}}', 'show_index', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cms_collections_and_entities}}', 'show_index');
    }
}
