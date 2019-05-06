<?php

use yii\db\Migration;

/**
 * Class m190506_081223_add_commission_id_to_application
 */
class m190506_081223_add_commission_id_to_application extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('educational_process.application', 'commission_id', $this->integer());
        $this->addForeignKey('fk_application_2_commission', 'educational_process.application', 'commission_id',
            'reception.commission', 'id');

        $admissionApplications = (new \yii\db\Query())->select('*')
            ->from('educational_process.application')
            ->all();
        foreach ($admissionApplications as $admissionApplication) {
            $commission = \common\models\reception\Commission::find()
                ->andWhere(['institution_id' => $admissionApplication['institution_id']])
                ->orderBy(['id' => SORT_DESC])->one();
            if ($commission) {
                $this->update('educational_process.application', [
                    'commission_id' => $commission->id
                ]);
            }
        }

        $this->execute('ALTER TABLE educational_process.application RENAME TO admission_application');
        $this->execute('ALTER TABLE educational_process.admission_application ALTER COLUMN commission_id SET NOT NULL');
        $this->execute('ALTER TABLE educational_process.admission_application SET SCHEMA reception');

        $this->execute('drop schema educational_process');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('create schema educational_process');
        $this->execute('ALTER TABLE reception.admission_application SET SCHEMA educational_process');
        $this->execute('ALTER TABLE educational_process.admission_application RENAME TO application');

        $this->dropColumn('educational_process.application', 'commission_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_081223_add_commission_id_to_application cannot be reverted.\n";

        return false;
    }
    */
}
