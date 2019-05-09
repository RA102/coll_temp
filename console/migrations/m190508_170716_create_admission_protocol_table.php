<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admission_protocol}}`.
 */
class m190508_170716_create_admission_protocol_table extends Migration
{
    private $tableName = 'reception.admission_protocol';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'commission_id' => $this->integer(),
            'number' => $this->string(65),
            'completion_date' => $this->date(),
            'status' => $this->smallInteger()->notNull(),
            'create_ts' => $this->timestamp()->defaultExpression('now()'),
            'update_ts' => $this->timestamp()->defaultExpression('now()'),
            'delete_ts' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'fk_admission_protocol_2_commission',
            $this->tableName,
            'commission_id',
            'reception.commission',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_admission_protocol_2_commission', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
