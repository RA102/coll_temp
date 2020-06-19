<?php

use common\models\person\PersonCredential;
use yii\db\Migration;

/**
 * Class m200619_034022_add_emptypassenter_to_person_credentials
 */
class m200619_034022_add_emptypassenter_to_person_credentials extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(PersonCredential::tableName(), 'emptypassenter', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200619_034022_add_emptypassenter_to_person_credentials cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200619_034022_add_emptypassenter_to_person_credentials cannot be reverted.\n";

        return false;
    }
    */
}
