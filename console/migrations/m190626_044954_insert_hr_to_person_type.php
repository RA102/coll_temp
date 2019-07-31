<?php

use yii\db\Migration;

/**
 * Class m190626_044954_insert_hr_to_person_type
 */
class m190626_044954_insert_hr_to_person_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('person.person_type', [
            'name' => 'hr', 
            'group' => 3, 
            'caption' => '{"kk": "HR", "ru": "HR"}',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m190626_044954_insert_hr_to_person_type cannot be reverted.\n";

        //return false;
        
        $this->delete('person.person_type', [
            'name' => 'hr',
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190626_044954_insert_hr_to_person_type cannot be reverted.\n";

        return false;
    }
    */
}
