<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization_stats}}`.
 */
class m191007_073827_create_stats_table extends Migration
{
    private $tableName = 'organization.stats';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
        ]);
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
