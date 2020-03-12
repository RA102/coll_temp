<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200119_084407_create_rups_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rup_subjects', [
            'id' => $this->primaryKey(),
            'id_sub_block' => $this->integer(),
            'id_block' => $this->integer(),
            'exam' => $this->integer(),
            'control_work' => $this->integer(),
            'offset' => $this->integer(),
            'time' => $this->integer(),
            'teory_time' => $this->integer(),
            'lab_time' => $this->integer(),
            'production_practice_time' => $this->integer(),
            'one_sem_time' => $this->integer(),
            'two_sem_time' => $this->integer(),
            'three_sem_time' => $this->integer(),
            'four_sem_time' => $this->integer(),
            'five_sem_time' => $this->integer(),
            'six_sem_time' => $this->integer(),
            'seven_sem_time' => $this->integer(),
            'eight_sem_time' => $this->integer(),
            'name' => $this->string(400)->null(),
            'rup_id' => $this->integer()->null(),
            'code' => $this->string(20)->null(),
        ]);

        $this->addForeignKey('fk_module_subjects_2_info', 'rup_subjects', 'id_sub_block', 'rup_module', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rup_subjects');
        $this->dropForeignKey('fk_module_subjects_2_info', 'rup_subjects');
    }
}
