<?php

use yii\db\Migration;

/**
 * Class m190502_035042_add_application_reason
 */
class m190502_035042_add_application_reason extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('educational_process.application', 'reason', $this->text());
        $this->addColumn('educational_process.application', 'history', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('educational_process.application', 'reason');
        $this->dropColumn('educational_process.application', 'history');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190502_035042_add_application_reason cannot be reverted.\n";

        return false;
    }
    */
}
