<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200119_084404_create_rups_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rup_block', [
            'id' => $this->primaryKey(),
            'rup_id' => $this->integer()->null(),
            'code' => $this->string(20)->null(),
            'name' => $this->string(300)->null(),
            'time' => $this->smallInteger(),
            'isTemplate'=>$this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rup_block');
    }
}
