<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_entities}}`.
 */
class m211429_176101_rename_entity_wetermark_column extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
        $this->renameColumn('cms_entities','disable_watermark','use_watermark');
    }

	public function safeDown()
	{
        $this->renameColumn('cms_entities','disable_watermark','use_watermark');
    }
}
