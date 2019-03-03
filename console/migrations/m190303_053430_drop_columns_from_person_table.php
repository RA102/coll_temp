<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `columns_from_person`.
 */
class m190303_053430_drop_columns_from_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('person.person', 'email');
        $this->dropColumn('person.person', 'password_reset_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('person.person', 'email', $this->string()->unique());
        $this->addColumn('person.person', 'password_reset_token', $this->string());
    }
}
