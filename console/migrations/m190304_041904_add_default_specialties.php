<?php

use yii\db\Migration;

/**
 * Class m190304_041904_add_default_specialties
 */
class m190304_041904_add_default_specialties extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('handbook.speciality', 'oid', $this->bigInteger());

        $this->dropForeignKey('fk_speciality_2_speciality', 'handbook.speciality');

        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/speciality.sql"))
        );
        $this->addForeignKey(
            'fk_speciality_2_speciality',
            'handbook.speciality',
            'parent_id',
            'handbook.speciality',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
