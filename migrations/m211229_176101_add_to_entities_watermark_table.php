<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_entities}}`.
 */
class m211229_176101_add_to_entities_watermark_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
        $this->addColumn('cms_entities', 'disable_watermark', $this->tinyInteger());
    }

	public function safeDown()
	{
        $this->dropColumn('cms_entities', 'disable_watermark');
	}
}
