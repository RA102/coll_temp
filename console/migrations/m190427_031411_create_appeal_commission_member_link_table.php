<?php

use yii\db\Migration;

/**
 * Handles the creation of table `appeal_commission_member_link`.
 */
class m190427_031411_create_appeal_commission_member_link_table extends Migration
{
    private $tableName = 'link.appeal_commission_member_link';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'appeal_commission_id' => $this->bigInteger()->notNull(),
            'member_id' => $this->bigInteger()->notNull(),
            'role' => $this->integer()->defaultValue(1),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk_appeal_commission_member_link_2_appeal_commission',
            $this->tableName,
            'appeal_commission_id',
            'reception.appeal_commission',
            'id'
        );

        $this->addForeignKey(
            'fk_appeal_commission_member_link_2_employee',
            $this->tableName,
            'member_id',
            'person.person',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_appeal_commission_member_link_2_employee', $this->tableName);
        $this->dropForeignKey('fk_appeal_commission_member_link_2_appeal_commission', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
