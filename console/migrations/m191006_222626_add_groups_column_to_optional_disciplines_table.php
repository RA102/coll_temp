<?php

use yii\db\Migration;

/**
 * Handles adding groups to table `{{%optional_disciplines}}`.
 */
class m191006_222626_add_groups_column_to_optional_disciplines_table extends Migration
{
    private $tableName = 'public.optional_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'groups', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'groups');
    }
}
