<?php

use yii\db\Migration;

/**
 * Handles adding ktp to table `{{%required_disciplines}}`.
 */
class m190928_043930_add_ktp_column_to_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'ktp', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'ktp');
    }
}
