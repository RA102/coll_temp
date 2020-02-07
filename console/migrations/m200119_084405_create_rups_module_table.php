<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200119_084405_create_rups_module_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rup_module', [
            'id' => $this->primaryKey(),
            'rup_id' => $this->integer()->null(),
            'code' => $this->string(20)->null(),
            'name' => $this->string(300)->null(),
            'time' => $this->smallInteger(),
            'block_id'=>$this->integer()
        ]);

        $this->addForeignKey('fk_module_block_2_info', 'rup_module', 'block_id', 'rup_block', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rup_module');
        $this->dropForeignKey('fk_module_block_2_info', 'rup_module');
    }
}
