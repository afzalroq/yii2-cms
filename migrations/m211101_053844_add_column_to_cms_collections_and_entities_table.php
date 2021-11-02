<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_collections_and_entities}}`.
 */
class m211101_053844_add_column_to_cms_collections_and_entities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cms_collections_and_entities}}', 'location', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cms_collections_and_entities}}', 'location', $this->tinyInteger());
    }
}
