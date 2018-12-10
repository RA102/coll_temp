<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nationality`.
 */
class m181210_171710_create_nationality_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.nationality', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('person.nationality');
    }
}
