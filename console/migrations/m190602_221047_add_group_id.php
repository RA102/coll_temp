<?php

use common\models\organization\Group;
use yii\db\Migration;

/**
 * Class m190602_221047_add_group_id
 */
class m190602_221047_add_group_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Group::tableName(), 'group_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Group::tableName(), 'group_id');
    }
}
