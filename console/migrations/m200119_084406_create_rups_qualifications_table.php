<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200119_084406_create_rups_qualifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rup_qualifications', [
            'id' => $this->primaryKey(),
            'rup_id' => $this->integer()->null(),
            'qualification_code' => $this->string(20)->null(),
            'qualification_name' => $this->string(300)->null(),
            'time_years' => $this->smallInteger(),
            'time_months' => $this->smallInteger(),
            'q_level'=>$this->string(300)
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rup_qualifications');
    }
}
