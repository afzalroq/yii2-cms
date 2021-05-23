<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_options}}`.
 */
class m210201_175334_add_columns_to_cms_entities_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_entities', 'disable_create_and_delete', $this->tinyInteger());
    }

    public function safeDown()
    {
        $this->dropColumn('cms_entities', 'disable_create_and_delete');
    }
}
