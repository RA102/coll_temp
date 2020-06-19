<?php

use common\models\organization\Group;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%group}}`.
 */
class m200619_053311_add_department_id_column_to_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Group::tableName(), 'department_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Group::tableName(), 'department_id');
    }
}
