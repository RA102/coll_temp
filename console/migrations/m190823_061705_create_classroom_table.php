<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%classroom}}`.
 */
class m190823_061705_create_classroom_table extends Migration
{
    private $tableName = 'organization.classroom';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer(),
            'number' => $this->string(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
