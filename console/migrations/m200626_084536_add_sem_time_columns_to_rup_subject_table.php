<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rup_subject}}`.
 */
class m200626_084536_add_sem_time_columns_to_rup_subject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('rup_subjects', 'one_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_teory_time', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_teory_time', $this->integer());

        $this->addColumn('rup_subjects', 'one_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_lab_time', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_lab_time', $this->integer());

        $this->addColumn('rup_subjects', 'one_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_production_practice_time', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_production_practice_time', $this->integer());

        $this->addColumn('rup_subjects', 'one_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_exam', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_exam', $this->integer());

        $this->addColumn('rup_subjects', 'one_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_offset', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_offset', $this->integer());

        $this->addColumn('rup_subjects', 'one_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'two_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'three_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'four_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'five_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'six_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'seven_sem_control_work', $this->integer());
        $this->addColumn('rup_subjects', 'eight_sem_control_work', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('rup_subjects', 'one_sem_teory_time');
        $this->dropColumn('rup_subjects', 'two_sem_teory_time');
        $this->dropColumn('rup_subjects', 'three_sem_teory_time');
        $this->dropColumn('rup_subjects', 'four_sem_teory_time');
        $this->dropColumn('rup_subjects', 'five_sem_teory_time');
        $this->dropColumn('rup_subjects', 'six_sem_teory_time');
        $this->dropColumn('rup_subjects', 'seven_sem_teory_time');
        $this->dropColumn('rup_subjects', 'eight_sem_teory_time');

        $this->dropColumn('rup_subjects', 'one_sem_lab_time');
        $this->dropColumn('rup_subjects', 'two_sem_lab_time');
        $this->dropColumn('rup_subjects', 'three_sem_lab_time');
        $this->dropColumn('rup_subjects', 'four_sem_lab_time');
        $this->dropColumn('rup_subjects', 'five_sem_lab_time');
        $this->dropColumn('rup_subjects', 'six_sem_lab_time');
        $this->dropColumn('rup_subjects', 'seven_sem_lab_time');
        $this->dropColumn('rup_subjects', 'eight_sem_lab_time');

        $this->dropColumn('rup_subjects', 'one_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'two_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'three_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'four_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'five_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'six_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'seven_sem_production_practice_time');
        $this->dropColumn('rup_subjects', 'eight_sem_production_practice_time');

        $this->dropColumn('rup_subjects', 'one_sem_exam');
        $this->dropColumn('rup_subjects', 'two_sem_exam');
        $this->dropColumn('rup_subjects', 'three_sem_exam');
        $this->dropColumn('rup_subjects', 'four_sem_exam');
        $this->dropColumn('rup_subjects', 'five_sem_exam');
        $this->dropColumn('rup_subjects', 'six_sem_exam');
        $this->dropColumn('rup_subjects', 'seven_sem_exam');
        $this->dropColumn('rup_subjects', 'eight_sem_exam');

        $this->dropColumn('rup_subjects', 'one_sem_offset');
        $this->dropColumn('rup_subjects', 'two_sem_offset');
        $this->dropColumn('rup_subjects', 'three_sem_offset');
        $this->dropColumn('rup_subjects', 'four_sem_offset');
        $this->dropColumn('rup_subjects', 'five_sem_offset');
        $this->dropColumn('rup_subjects', 'six_sem_offset');
        $this->dropColumn('rup_subjects', 'seven_sem_offset');
        $this->dropColumn('rup_subjects', 'eight_sem_offset');

        $this->dropColumn('rup_subjects', 'one_sem_control_work');
        $this->dropColumn('rup_subjects', 'two_sem_control_work');
        $this->dropColumn('rup_subjects', 'three_sem_control_work');
        $this->dropColumn('rup_subjects', 'four_sem_control_work');
        $this->dropColumn('rup_subjects', 'five_sem_control_work');
        $this->dropColumn('rup_subjects', 'six_sem_control_work');
        $this->dropColumn('rup_subjects', 'seven_sem_control_work');
        $this->dropColumn('rup_subjects', 'eight_sem_control_work');
    }
}
