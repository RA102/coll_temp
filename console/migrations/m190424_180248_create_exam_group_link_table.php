<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exam_group_link`.
 */
class m190424_180248_create_exam_group_link_table extends Migration
{
    private $tableName = 'reception.exam_group_link';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_exam_group_link_2_exam', $this->tableName, 'exam_id', 'reception.exam', 'id');
        $this->addForeignKey('fk_exam_group_link_2_group', $this->tableName, 'group_id', 'reception.group', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_exam_group_link_2_group', $this->tableName);
        $this->dropForeignKey('fk_exam_group_link_2_exam', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
