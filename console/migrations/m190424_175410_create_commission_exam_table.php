<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commission_exam`.
 */
class m190424_175410_create_commission_exam_table extends Migration
{
    private $tableName = 'reception.exam';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'commission_id' => $this->integer()->notNull(),
            'institution_discipline_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer(),
            'date_ts' => $this->timestamp(),
        ]);

        $this->addForeignKey('fk_exam_2_commission', $this->tableName, 'commission_id', 'reception.commission', 'id');
        $this->addForeignKey('fk_exam_2_institution_discipline', $this->tableName, 'institution_discipline_id', 'organization.institution_discipline', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_exam_2_institution_discipline', $this->tableName);
        $this->dropForeignKey('fk_exam_2_commission', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
