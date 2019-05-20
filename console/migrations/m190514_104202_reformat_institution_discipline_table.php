<?php

use yii\db\Migration;

/**
 * Class m190514_104202_reformat_institution_discipline_table
 */
class m190514_104202_reformat_institution_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('organization.institution_discipline', [
            'types' => '{}',
        ], [
            'types' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190514_104202_reformat_institution_discipline_table cannot be reverted.\n";

        return false;
    }
    */
}
