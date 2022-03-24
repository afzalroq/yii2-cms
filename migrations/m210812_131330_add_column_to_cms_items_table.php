<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_items}}`.
 */
class m210812_131330_add_column_to_cms_items_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%cms_items}}', 'votes_count', $this->integer()->defaultValue(0));
        $this->addColumn('{{%cms_items}}', 'comments_count', $this->integer()->defaultValue(0));
        $this->addColumn('{{%cms_items}}', 'avarage_voting', $this->decimal(5,1));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%cms_items}}', 'votes_count');
        $this->dropColumn('{{%cms_items}}', 'comments_count');
        $this->dropColumn('{{%cms_items}}', 'avarage_voting');
    }
}
