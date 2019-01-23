<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m190123_052501_create_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE SCHEMA system;");
        $this->createTable('system.setting', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'value' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('system.setting');
        $this->execute("DROP SCHEMA system;");
    }
}
