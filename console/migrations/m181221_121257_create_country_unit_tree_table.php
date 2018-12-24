<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country_unit_tree`.
 */
class m181221_121257_create_country_unit_tree_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('country_unit_tree', [
            'id' => $this->primaryKey(),
            'id_parent' => $this->integer()->notNull(),
            'id_child' => $this->integer()->notNull(),
            'level' => $this->smallInteger()->notNull(),
            'is_root' => $this->smallInteger(),
            'path' => $this->text(),
        ]);

        $this->addForeignKey('fk_country_unit_tree_2_country_unit_parent', 'country_unit_tree', 'id_parent', 'country_unit', 'id');
        $this->addForeignKey('fk_country_unit_tree_2_country_unit_child', 'country_unit_tree', 'id_child', 'country_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_country_unit_tree_2_country_unit_child', 'country_unit_tree');
        $this->dropForeignKey('fk_country_unit_tree_2_country_unit_parent', 'country_unit_tree');

        $this->dropTable('country_unit_tree');
    }
}
