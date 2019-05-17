<?php

use yii\db\Migration;

/**
 * Class m190508_044913_add_type_to_reception_exam
 */
class m190508_044913_add_type_to_reception_exam extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.exam', 'type', $this->smallInteger()->notNull()->defaultValue(1)->after('teacher_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reception.exam', 'type');
    }
}
