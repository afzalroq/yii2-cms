<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cms_entities}}`.
 */
class m211329_176101_add_created_by_and_updated_by_columns extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
	    //cms options
        $this->addColumn('cms_options', 'created_by', $this->integer());
        $this->addColumn('cms_options', 'updated_by', $this->integer());
        //cms items
        $this->addColumn('cms_items', 'created_by', $this->integer());
        $this->addColumn('cms_items', 'updated_by', $this->integer());
        //cms menu
        $this->addColumn('cms_menu', 'created_by', $this->integer());
        $this->addColumn('cms_menu', 'updated_by', $this->integer());
    }

	public function safeDown()
	{
	    // drop options
        $this->dropColumn('cms_options', 'created_by');
        $this->dropColumn('cms_options', 'updated_by');
        // drop items
        $this->dropColumn('cms_items', 'created_by');
        $this->dropColumn('cms_items', 'updated_by');
        // drop menu
        $this->dropColumn('cms_menu', 'created_by');
        $this->dropColumn('cms_menu', 'updated_by');
	}
}
