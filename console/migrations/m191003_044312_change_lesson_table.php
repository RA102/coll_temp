<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m191003_044312_change_lesson_table
 */
class m191003_044312_change_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Lesson::tableName(), 'weekday');
        $this->dropColumn(Lesson::tableName(), 'number');

        $this->addColumn(Lesson::tableName(), 'topic', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'topic');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191003_044312_change_lesson_table cannot be reverted.\n";

        return false;
    }
    */
}
