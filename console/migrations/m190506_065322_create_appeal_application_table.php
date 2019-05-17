<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appeal_application}}`.
 */
class m190506_065322_create_appeal_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reception.appeal_application', [
            'id' => $this->primaryKey(),
            'appeal_commission_id' => $this->integer(),
            'entrant_id' => $this->bigInteger()->notNull(),
            'reason' => $this->text(),
            'status' => $this->tinyInteger()->defaultValue(1),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->timestamp(),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk_appeal_application_2_appeal_commission',
            'reception.appeal_application',
            'appeal_commission_id',
            'reception.appeal_commission',
            'id'
        );

        $this->addForeignKey(
            'fk_appeal_application_2_entrant',
            'reception.appeal_application',
            'entrant_id',
            'person.person',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_appeal_application_2_entrant', 'reception.appeal_application');
        $this->dropForeignKey('fk_appeal_application_2_appeal_commission', 'reception.appeal_application');
        $this->dropTable('reception.appeal_application');
    }
}
