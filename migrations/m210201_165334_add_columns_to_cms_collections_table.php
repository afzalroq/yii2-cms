<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_options}}`.
 */
class m210201_165334_add_columns_to_cms_collections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cms_collections', 'manual_slug', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cms_collections', 'manual_slug');
    }
}
