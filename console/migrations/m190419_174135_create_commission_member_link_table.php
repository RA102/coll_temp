<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commission_employee_link`.
 */
class m190419_174135_create_commission_member_link_table extends Migration
{
    private $tableName = 'link.commission_member_link';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'commission_id' => $this->bigInteger()->notNull(),
            'member_id' => $this->bigInteger()->notNull(),
            'role' => $this->integer()->defaultValue(1),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk_commission_member_link_2_commission',
            $this->tableName,
            'commission_id',
            'reception.commission',
            'id'
        );

        $this->addForeignKey(
            'fk_commission_member_link_2_employee',
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
        $this->dropForeignKey('fk_commission_member_link_2_employee', $this->tableName);
        $this->dropForeignKey('fk_commission_member_link_2_commission', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
