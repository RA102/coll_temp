<?php

use yii\db\Migration;

/**
 * Handles the creation of table `appeal_commission`.
 */
class m190424_165848_create_appeal_commission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reception.appeal_commission', [
            'id' => $this->primaryKey(),
            'caption' => 'jsonb',
            'commission_id' => $this->integer(),
            'from_date' => $this->date(),
            'to_date' => $this->date(),
            'order_number' => $this->string(),
            'order_date' => $this->date(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->timestamp(),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk_appeal_commission_2_commission',
            'reception.appeal_commission',
            'commission_id',
            'reception.commission',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_appeal_commission_2_commission', 'reception.appeal_commission');
        $this->dropTable('reception.appeal_commission');
    }
}
