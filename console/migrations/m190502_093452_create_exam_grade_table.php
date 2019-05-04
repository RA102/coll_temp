<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exam_grade`.
 */
class m190502_093452_create_exam_grade_table extends Migration
{
    private $tableName = 'reception.exam_grade';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'entrant_id' => $this->integer()->notNull(),
            'exam_id' => $this->integer()->notNull(),
            'grade' => $this->string(),
            'history' => $this->text(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_exam_grade_2_exam', $this->tableName, 'exam_id', 'reception.exam', 'id');
        $this->addForeignKey('fk_exam_grade_2_entrant', $this->tableName, 'entrant_id', 'person.person', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_exam_grade_2_entrant', $this->tableName);
        $this->dropForeignKey('fk_exam_grade_2_exam', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
