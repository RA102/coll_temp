<?php

use yii\db\Migration;

/**
 * Class m190506_093908_add_column_grade_type_to_exam_related_tables
 */
class m190506_093908_add_column_grade_type_to_exam_related_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.exam', 'grade_type', $this->smallInteger()->notNull()->defaultValue(0)->after('teacher_id'));
        $this->addColumn('reception.exam_grade', 'grade_type', $this->smallInteger()->notNull()->defaultValue(0)->after('exam_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reception.exam_grade', 'grade_type');
        $this->dropColumn('reception.exam', 'grade_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_093908_add_column_grade_type_to_exam_related_tables cannot be reverted.\n";

        return false;
    }
    */
}
