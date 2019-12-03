<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190823_092038_add_classroom_id_to_lesson_table
 */
class m190823_092038_add_classroom_id_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Lesson::tableName(), 'classroom_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'classroom_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_092038_add_classroom_id_to_lesson_table cannot be reverted.\n";

        return false;
    }
    */
}
