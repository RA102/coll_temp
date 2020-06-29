<?php

use common\models\organization\InstitutionDiscipline;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%institution_discipline}}`.
 */
class m200619_053124_add_department_id_column_to_institution_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(InstitutionDiscipline::tableName(), 'department_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(InstitutionDiscipline::tableName(), 'department_id');
    }
}
