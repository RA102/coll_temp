<?php

use yii\db\Migration;

/**
 * Class m200528_091034_add_qualcode_to_rupblock
 */
class m200528_091034_add_qualcode_to_rupblock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('rup_block', 'qual_code', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'position');
        echo "m200528_091034_add_qualcode_to_rupblock - column qual_code droped. \n";
        //echo "m200528_091034_add_qualcode_to_rupblock cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200528_091034_add_qualcode_to_rupblock cannot be reverted.\n";

        return false;
    }
    */
}
