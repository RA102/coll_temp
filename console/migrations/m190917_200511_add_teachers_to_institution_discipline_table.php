<?php

use common\models\organization\InstitutionDiscipline;
use yii\db\Migration;

/**
 * Class m190917_200511_add_teachers_to_institution_discipline_table
 */
class m190917_200511_add_teachers_to_institution_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(InstitutionDiscipline::tableName(), 'teachers', 'INT[]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(InstitutionDiscipline::tableName(), 'teachers');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190917_200511_add_teachers_to_institution_discipline_table cannot be reverted.\n";

        return false;
    }
    */
}
