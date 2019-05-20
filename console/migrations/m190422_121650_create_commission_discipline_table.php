<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commission_discipline`.
 */
class m190422_121650_create_commission_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link.commission_discipline_link', [
            'id' => $this->primaryKey(),
            'commission_id' => $this->integer()->notNull(),
            'institution_discipline_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_commission_discipline_2_commission', 'link.commission_discipline_link', 'commission_id', 'reception.commission', 'id');
        $this->addForeignKey('fk_commission_discipline_2_institution_discipline', 'link.commission_discipline_link', 'institution_discipline_id', 'organization.institution_discipline', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_commission_discipline_2_institution_discipline', 'link.commission_discipline_link');
        $this->dropForeignKey('fk_commission_discipline_2_commission', 'link.commission_discipline_link');

        $this->dropTable('link.commission_discipline_link');
    }
}
