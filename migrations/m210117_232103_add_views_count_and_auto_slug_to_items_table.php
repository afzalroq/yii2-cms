<?php

use yii\db\Migration;


class m210117_232103_add_views_count_and_auto_slug_to_items_table extends Migration
{

	public function safeUp()
	{
        $this->addColumn('cms_entities', 'manual_slug', $this->tinyInteger());
        $this->addColumn('cms_entities', 'use_views_count', $this->tinyInteger());
        $this->addColumn('cms_items', 'views_count', $this->integer()->defaultValue(0));
	}

	public function safeDown()
	{
        $this->dropColumn('cms_entities', 'use_views_count');
        $this->dropColumn('cms_entities', 'manual_slug');
        $this->dropColumn('cms_items', 'views_count');
	}
}
