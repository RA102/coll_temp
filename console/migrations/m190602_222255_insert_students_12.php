<?php

use common\models\link\StudentGroupLink;
use common\models\person\Person;
use yii\db\Migration;

/**
 * Class m190602_222255_insert_students_12
 */
class m190602_222255_insert_students_12 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insertPersonsLink();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    private function insertPersonsLink()
    {
        $file_path = Yii::getAlias("@console/resources/db_dumps/group_link_12.csv");
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle)) !== FALSE) {
                $i++;
                echo "=== \n";

                /* @var Person $person */
                $person = Person::findOne(['portal_uid' => $data[0]]);

                if (!$person) {
                    echo 'No person: ' . $i . ' ' . $data[0] . "\n";
                    continue;
                }

                $group = \common\models\organization\Group::findOne([
                    'group_id' => $data[1],
                    'institution_id' => 30
                ]);
                if (!$group) {
                    echo 'No group: ' . $i . ' ' . $data[1] . "\n";
                    continue;
                }

                $this->insert(StudentGroupLink::tableName(), [
                    'student_id' => $person->id,
                    'group_id' => $group->id,
                ]);
            }
            fclose($handle);
        }
    }
}
