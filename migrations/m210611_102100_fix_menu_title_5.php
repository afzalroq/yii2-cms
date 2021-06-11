<?php

use yii\db\Migration;

class m210611_102100_fix_menu_title_5 extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cms_menu', 'title_4', $this->string()->after('title_3'));
    }

    public function safeDown()
    {
        $this->dropTable('{{%cms_options_and_items}}');
    }
}
