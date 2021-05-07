<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_entities}}`.
 */
class m211429_176102_rename_and_add_columns_to_items extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
        $this->renameColumn('cms_items','date','date_0');

        //adding columns to items
        $this->addColumn('cms_items','date_1',$this->integer()->unsigned());
        $this->addColumn('cms_items','date_2',$this->integer()->unsigned());
        $this->addColumn('cms_items','date_3',$this->integer()->unsigned());
        $this->addColumn('cms_items','date_4',$this->integer()->unsigned());
    }

	public function safeDown()
	{
        $this->renameColumn('cms_items','date','date_0');
        $this->dropColumn('cms_items','date_0');
        $this->dropColumn('cms_items','date_1');
        $this->dropColumn('cms_items','date_2');
        $this->dropColumn('cms_items','date_3');
        $this->dropColumn('cms_items','date_4');
    }
}
