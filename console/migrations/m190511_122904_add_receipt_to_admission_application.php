<?php

use yii\db\Migration;

/**
 * Class m190511_122904_add_receipt_to_admission_application
 */
class m190511_122904_add_receipt_to_admission_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.admission_application', 'receipt', 'jsonb');

        $this->dropColumn('reception.admission_application', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('reception.admission_application', 'type',
            $this->smallInteger()->notNull()->defaultValue(\common\helpers\ApplicationHelper::APPLICATION_TYPE_ADMISSION));

        $this->dropColumn('reception.admission_application', 'receipt');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190511_122904_add_receipt_to_admission_application cannot be reverted.\n";

        return false;
    }
    */
}
