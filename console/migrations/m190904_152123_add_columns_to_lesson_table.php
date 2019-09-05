<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190904_152123_add_columns_to_lesson_table
 */
class m190904_152123_add_columns_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Lesson::tableName(), 'weekday', $this->integer());
        $this->addColumn(Lesson::tableName(), 'number', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'weekday');
        $this->dropColumn(Lesson::tableName(), 'number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190904_152123_add_columns_to_lesson_table cannot be reverted.\n";

        return false;
    }
    */
}
