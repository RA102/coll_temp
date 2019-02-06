<?php

use yii\db\Migration;

/**
 * Handles the creation of table `speciality`.
 */
class m190206_093813_create_speciality_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE SCHEMA handbook;
        ");

        $this->createTable('handbook.speciality', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'parent_oid' => $this->integer(),
            'type' => $this->smallInteger(),
            'code' => $this->text(),
            'caption' => 'jsonb',
            'msko' =>$this->string(100),
            'gkz' => $this->string(100),
            'server_id' => $this->bigInteger(),
            'create_ts' => $this->timestamp(),
            'is_deleted' => $this->boolean(),
            'subjects' => $this->integer() . '[]',
            'is_working' => $this->boolean(),
            'institution_type' => $this->smallInteger()
        ]);

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
        $this->dropForeignKey('fk_speciality_2_speciality', 'handbook.speciality');
        $this->dropTable('handbook.speciality');

        $this->execute("
            DROP SCHEMA handbook;
        ");
    }
}
