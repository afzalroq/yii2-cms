<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cms_options}}`.
 */
class m211015_052640_add_column_to_cms_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

        $this->addColumn('{{%cms_options}}', 'text_1_0', $textType);
        $this->addColumn('{{%cms_options}}', 'text_1_1', $textType);
        $this->addColumn('{{%cms_options}}', 'text_1_2', $textType);
        $this->addColumn('{{%cms_options}}', 'text_1_3', $textType);
        $this->addColumn('{{%cms_options}}', 'text_1_4', $textType);
        $this->addColumn('{{%cms_options}}', 'text_2_0', $textType);
        $this->addColumn('{{%cms_options}}', 'text_2_1', $textType);
        $this->addColumn('{{%cms_options}}', 'text_2_2', $textType);
        $this->addColumn('{{%cms_options}}', 'text_2_3', $textType);
        $this->addColumn('{{%cms_options}}', 'text_2_4', $textType);
        $this->addColumn('{{%cms_options}}', 'text_3_0', $textType);
        $this->addColumn('{{%cms_options}}', 'text_3_1', $textType);
        $this->addColumn('{{%cms_options}}', 'text_3_2', $textType);
        $this->addColumn('{{%cms_options}}', 'text_3_3', $textType);
        $this->addColumn('{{%cms_options}}', 'text_3_4', $textType);
        $this->addColumn('{{%cms_options}}', 'text_4_0', $textType);
        $this->addColumn('{{%cms_options}}', 'text_4_1', $textType);
        $this->addColumn('{{%cms_options}}', 'text_4_2', $textType);
        $this->addColumn('{{%cms_options}}', 'text_4_3', $textType);
        $this->addColumn('{{%cms_options}}', 'text_4_4', $textType);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $textType = ($this->db->driverName === 'mysql') ? 'MEDIUMTEXT' : $this->text();

        $this->dropColumn('{{%cms_options}}', 'text_1_0', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_1_1', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_1_2', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_1_3', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_1_4', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_2_0', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_2_1', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_2_2', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_2_3', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_2_4', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_3_0', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_3_1', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_3_2', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_3_3', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_3_4', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_4_0', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_4_1', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_4_2', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_4_3', $textType);
        $this->dropColumn('{{%cms_options}}', 'text_4_4', $textType);
    }
}
