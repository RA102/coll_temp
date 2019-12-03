<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190822_113952_change_weeks_type_in_lesson_table
 */
class m190822_113952_change_weeks_type_in_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Lesson::tableName(), 'weeks');
        $this->addColumn(Lesson::tableName(), 'weeks', 'SMALLINT[]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'weeks');
        $this->addColumn(Lesson::tableName(), 'weeks', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_113952_change_weeks_type_in_lesson_table cannot be reverted.\n";

        return false;
    }
    */
}
