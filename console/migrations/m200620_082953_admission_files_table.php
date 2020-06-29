<?php

use yii\db\Migration;

/**
 * Class m200620_082953_admission_files_table
 */
class m200620_082953_admission_files_table extends Migration
{
    private $tableName = 'reception.admission_files';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'aa_id' => $this->integer(8),
            'person_id' => $this->integer(),
            'doc_type' => $this->string(100),
            'file_meta' => 'jsonb',
            'url' => $this->string(400),
            'state' => $this->integer(),
            'rec_add_ts' => $this->timestamp()->defaultExpression('now()'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200620_082953_admission_files_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200620_082953_admission_files_table cannot be reverted.\n";

        return false;
    }
    */
}
