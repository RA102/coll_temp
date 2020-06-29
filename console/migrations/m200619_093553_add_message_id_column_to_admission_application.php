<?php

use yii\db\Migration;

/**
 * Class m200619_093553_add_message_id_column_to_admission_application
 */
class m200619_093553_add_message_id_column_to_admission_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.admission_application', 'online_msg_id', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200619_093553_add_message_id_column_to_admission_application cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200619_093553_add_message_id_column_to_admission_application cannot be reverted.\n";

        return false;
    }
    */
}
