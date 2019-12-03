<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190821_101501_add_weeks_to_lesson_table
 */
class m190823_054731_drop_weeks_column_from_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Lesson::tableName(), 'weeks');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}