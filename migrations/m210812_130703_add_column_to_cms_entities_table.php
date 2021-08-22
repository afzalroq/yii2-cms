<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_entities}}`.
 */
class m210812_130703_add_column_to_cms_entities_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%cms_entities}}', 'use_comments', $this->tinyInteger());
        $this->addColumn('{{%cms_entities}}', 'max_level', $this->integer());
        $this->addColumn('{{%cms_entities}}', 'use_votes', $this->tinyInteger());
        $this->addColumn('{{%cms_entities}}', 'use_moderation', $this->boolean());
        $this->addColumn('{{%cms_entities}}', 'comment_without_login', $this->boolean());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%cms_entities}}', 'use_comment');
        $this->dropColumn('{{%cms_entities}}', 'use_votes');
        $this->dropColumn('{{%cms_entities}}', 'use_comment_text');
        $this->dropColumn('{{%cms_entities}}', 'use_parent_id');
        $this->dropColumn('{{%cms_entities}}', 'max_level_count');
        $this->dropColumn('{{%cms_entities}}', 'use_moderation');
        $this->dropColumn('{{%cms_entities}}', 'use_comment_count');
    }
}
