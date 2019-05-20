<?php

use yii\db\Migration;

/**
 * Class m190508_102722_add_column_points_to_exam_grade_table
 */
class m190508_102722_add_column_points_to_exam_grade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.exam_grade', 'points', $this->smallInteger()->notNull()->defaultValue(0)->after('grade'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reception.exam_grade', 'points');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_102722_add_column_points_to_exam_grade_table cannot be reverted.\n";

        return false;
    }
    */
}
