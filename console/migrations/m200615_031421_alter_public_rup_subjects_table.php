<?php

use yii\db\Migration;

/**
 * Class m200615_031421_alter_public_rup_subjects_table
 */
class m200615_031421_alter_public_rup_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('public.rup_subjects', 'id_discipline', 'integer');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.rup_subjects', 'id_discipline');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200615_031421_alter_public_rup_subjects_table cannot be reverted.\n";

        return false;
    }
    */
}
