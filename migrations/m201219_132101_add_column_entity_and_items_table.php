<?php

use yii\db\Migration;


class m201219_132101_add_column_entity_and_items_table extends Migration
{

	public function safeUp()
	{
        $this->addColumn('cms_entities', 'use_gallery', $this->tinyInteger());
        $this->addColumn('cms_items', 'main_photo_id', $this->integer());
	}

	public function safeDown()
	{

	}
}
