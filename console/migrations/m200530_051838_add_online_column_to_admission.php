<?php

use yii\db\Migration;

/**
 * Class m200530_051838_add_online_column_to_admission
 */
class m200530_051838_add_online_column_to_admission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.admission_application', 'online', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200530_051838_add_online_column_to_admission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200530_051838_add_online_column_to_admission cannot be reverted.\n";

        return false;
    }
    */
}
