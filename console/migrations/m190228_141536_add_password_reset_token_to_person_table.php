<?php

use yii\db\Migration;

/**
 * Class m190228_141536_add_password_reset_token_to_person_table
 */
class m190228_141536_add_password_reset_token_to_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('person.person', 'email', $this->string()->unique());
        $this->addColumn('person.person', 'password_reset_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('person.person', 'email');
        $this->dropColumn('person.person', 'password_reset_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190228_141536_add_password_reset_token_to_person_table cannot be reverted.\n";

        return false;
    }
    */
}
