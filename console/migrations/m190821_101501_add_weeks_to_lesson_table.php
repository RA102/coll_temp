<?php

use common\models\Lesson;
use yii\db\Migration;

/**
 * Class m190821_101501_add_weeks_to_lesson_table
 */
class m190821_101501_add_weeks_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Lesson::tableName(), 'weeks', '$this->string()');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'weeks');
    }
}