<?php

use yii\db\Migration;

/**
 * Class m190212_094110_alter_discipline_add_types_column
 */
class m190212_094110_alter_discipline_add_types_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('public.discipline', 'types', 'SMALLINT[]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.discipline', 'types');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_094110_alter_discipline_add_types_column cannot be reverted.\n";

        return false;
    }
    */
}
