<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190822_024646_add_group_id_to_lesson_table
 */
class m190822_024646_add_group_id_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Lesson::tableName(), 'group_id', $this->integer()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'group_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_024646_add_group_id_to_lesson_table cannot be reverted.\n";

        return false;
    }
    */
}
