<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%workload_discipline}}`.
 */
class m200626_114908_create_workload_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%workload_discipline}}', [
            'id' => $this->primaryKey(),
            'course' => $this->integer(),
            'year' => $this->integer(),
            'rup_time' => $this->integer(),
            'pol1_time' => $this->integer(),
            'rup_pol1_time' => $this->integer(),
            'pol2_time' => $this->integer(),
            'rup_pol2_time' => $this->integer(),
            'pol1_teory_time' => $this->integer(),
            'rup_pol1_teory_time' => $this->integer(),
            'pol2_teory_time' => $this->integer(),
            'rup_pol2_teory_time' => $this->integer(),
            'pol1_lab_time' => $this->integer(),
            'rup_pol1_lab_time' => $this->integer(),
            'pol2_lab_time' => $this->integer(),
            'rup_pol2_lab_time' => $this->integer(),
            'pol1_production_practice_time' => $this->integer(),
            'rup_pol1_production_practice_time' => $this->integer(),
            'pol2_production_practice_time' => $this->integer(),
            'rup_pol2_production_practice_time' => $this->integer(),
            'pol1_exam' => $this->integer(),
            'rup_pol1_exam' => $this->integer(),
            'pol2_exam' => $this->integer(),
            'rup_pol2_exam' => $this->integer(),
            'pol1_offset' => $this->integer(),
            'rup_pol1_offset' => $this->integer(),
            'pol2_offset' => $this->integer(),
            'rup_pol2_offset' => $this->integer(),
            'pol1_control_work' => $this->integer(),
            'rup_pol1_control_work' => $this->integer(),
            'pol2_control_work' => $this->integer(),
            'rup_pol2_control_work' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%workload_discipline}}');
    }
}
