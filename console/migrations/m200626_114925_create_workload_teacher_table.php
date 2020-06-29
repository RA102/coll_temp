<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%workload_teacher}}`.
 */
class m200626_114925_create_workload_teacher_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%workload_teacher}}', [
            'id' => $this->primaryKey(),
            'rup_id' => $this->integer(),
            'id_discipline' => $this->integer(),
            'year' => $this->integer(),
            'course' => $this->integer(),
            'workload_discipline_id' => $this->integer(),
            'delete_ts' => $this->dateTime()->null(),
            'delete_user' => $this->dateTime()->null(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'create_user' => $this->dateTime()->notNull()->defaultValue('now()'),
            'pol1_time' => $this->integer(),
            'pol2_time' => $this->integer(),
            'pol1_teory_time' => $this->integer(),
            'pol2_teory_time' => $this->integer(),
            'pol1_lab_time' => $this->integer(),
            'pol2_lab_time' => $this->integer(),
            'pol1_production_practice_time' => $this->integer(),
            'pol2_production_practice_time' => $this->integer(),
            'pol1_exam' => $this->integer(),
            'pol1_offset' => $this->integer(),
            'pol2_offset' => $this->integer(),
            'pol1_control_work' => $this->integer(),
            'pol2_control_work' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%workload_teacher}}');
    }
}
