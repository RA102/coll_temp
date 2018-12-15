<?php

use yii\db\Migration;

/**
 * Class m181215_101006_add_new_columns_to_organization
 */
class m181215_101006_add_new_columns_to_organization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization.institution', 'max_shift', $this->smallInteger()->defaultValue(1));
        $this->addColumn('organization.institution', 'min_grade', $this->smallInteger()->defaultValue(0));
        $this->addColumn('organization.institution', 'enable_fraction', $this->boolean()->defaultValue(false));
        $this->addColumn('organization.institution', 'is_test', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('organization.institution', 'is_test');
        $this->dropColumn('organization.institution', 'enable_fraction');
        $this->dropColumn('organization.institution', 'min_grade');
        $this->dropColumn('organization.institution', 'max_shift');
    }
}
