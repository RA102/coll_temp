<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reception_commission`.
 */
class m190417_061057_create_reception_commission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE SCHEMA reception;
        ");

        $this->createTable('reception.commission', [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer(),
            'caption' => 'jsonb',
            'from_date' => $this->date(),
            'to_date' => $this->date(),
            'order_number' => $this->string(),
            'order_date' => $this->date(),
            'exam_start_date' => $this->date(),
            'exam_end_date' => $this->date(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'create_ts' => $this->timestamp(),
            'update_ts' => $this->timestamp(),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('fk_reception_commission_2_institution', 'reception.commission', 'institution_id', 'organization.institution', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_reception_commission_2_institution', 'reception.commission');

        $this->dropTable('reception.commission');

        $this->execute("
            DROP SCHEMA reception;
        ");
    }
}
