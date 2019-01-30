<?php

use common\models\Nationality;
use yii\db\Migration;

/**
 * Class m190130_175711_add_default_nationalities
 */
class m190130_175711_add_default_nationalities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(Nationality::tableName(), [
            'name'    => 'Казах/Казашка',
            'sort'    => 1,
        ]);
        $this->insert(Nationality::tableName(), [
            'name'    => 'Русский/Русская',
            'sort'    => 2,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190130_175711_add_default_nationalities cannot be reverted.\n";

        return false;
    }
    */
}
