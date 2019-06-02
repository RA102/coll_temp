<?php

use common\models\link\PersonInstitutionLink;
use common\models\person\Person;
use yii\db\Migration;

/**
 * Class m190602_112237_fix_person_status
 */
class m190602_112237_fix_person_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $person_ids = array_map(function(PersonInstitutionLink $model) {
            return $model->person_id;
        }, PersonInstitutionLink::find()
            ->where([
                'OR',
                ['<', 'to_ts', date('Y-m-d')],
                ['is_deleted' => true],
            ])
            ->all()
        );

        Person::updateAll(['status' => Person::STATUS_FIRED], ['id' => $person_ids]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
