<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_options}}`.
 */
class m210201_145334_add_columns_to_cms_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cms_options', 'tree', $this->integer()->notNull());
        $this->addColumn('cms_options', 'lft', $this->integer()->notNull());
        $this->addColumn('cms_options', 'rgt', $this->integer()->notNull());
        $this->addColumn('cms_options', 'depth', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cms_options', 'tree');
        $this->dropColumn('cms_options', 'lft');
        $this->dropColumn('cms_options', 'rgt');
        $this->dropColumn('cms_options', 'depth');
    }
}
