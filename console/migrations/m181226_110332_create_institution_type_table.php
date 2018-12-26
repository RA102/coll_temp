<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institution_type`.
 */
class m181226_110332_create_institution_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_type', [
            'id' => $this->primaryKey(),
            'caption' => 'jsonb',
            'parent_id' => $this->integer(),
            'is_deleted' => $this->boolean(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

//        $this->addForeignKey(
//            'fk_institution_type_2_institution_type',
//            'organization.institution_type',
//            'parent_id',
//            'organization.institution_type',
//            'id'
//        );

        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/institution_type.sql"))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey('fk_institution_type_2_institution_type', 'organization.institution_type');

        $this->dropTable('organization.institution_type');
    }
}
