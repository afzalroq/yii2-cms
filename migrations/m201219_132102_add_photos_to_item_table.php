<?php

use yii\db\Migration;


class m201219_132102_add_photos_to_item_table extends Migration
{

	public function safeUp()
	{
        $this->createIndex(
            'index-cms_item-photos-main',
            'cms_items',
            'main_photo_id'
        );
        $this->addForeignKey(
            'fkey-cms_item-photos-main',
            'cms_items',
            'main_photo_id',
            'cms_item_photos',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        $this->createIndex(
            'index-cms_item_id',
            'cms_item_photos',
            'cms_item_id'
        );

        $this->addForeignKey(
            'fkey-cms_item_id',
            'cms_item_photos',
            'cms_item_id',
            'cms_items',
            'id',
            'SET NULL',
            'RESTRICT'
        );
	}

	public function safeDown()
	{

	}
}
