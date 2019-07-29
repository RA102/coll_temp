<?php

use common\models\link\StudentGroupLink;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\person\Person;
use yii\db\Migration;

/**
 * Class m190429_105048_insert_groups
 */
class m190429_105048_insert_groups extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return true;
        $this->insertInstitutions();

        $this->insertPersonsLink();

        $this->execute(
            "SELECT pg_catalog.setval('organization.group_id_seq', :max_id, true);",
            [":max_id" => Group::find()->max('id') + 1]
        );
        $this->execute(
            "SELECT pg_catalog.setval('link.student_group_link_id_seq', :max_id, true);",
            [":max_id" => StudentGroupLink::find()->max('id') + 1]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
    }

    private function insertInstitutions()
    {
        $file_path = Yii::getAlias("@console/resources/db_dumps/groups.csv");
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                $i++;
                echo "=== \n";
                if (!isset($data[3])) {
                    echo 'No 1: ' . $i . ' ' . $data[0] . "\n";
                    break;
                }

                $institution_name_obj = json_decode($data[3]);

                if ($institution_name_obj === null) {
                    echo 'No 2: ' . $i . ' ' . $data[3] . "\n";
                    break;
                }

                if (!isset($institution_name_obj->ru)) {
                    echo 'No 3: ' . $i . ' ' . $institution_name_obj . "\n";
                    break;
                }

                /* @var Institution $institution */
                $institution = Institution::findOne(['name' => $institution_name_obj->ru]);

                if (!$institution) {
                    echo 'No: ' . $i . ' ' . $institution_name_obj->ru . "\n";
                    continue;
                }

                $this->insert(Group::tableName(), [
                    'id' => $data[0], // id
                    'caption' => $data[1], // caption
                    'institution_id' => $institution->id, // institution_id
                    'start_ts' => $data[4], // start_ts
                    'is_deleted' => $data[5], // is_deleted
                    'create_ts' => $data[6], // create_ts
                    'properties' => $data[7], // properties
                ]);
            }
            fclose($handle);
        }
    }

    private function insertPersonsLink()
    {
        $file_path = Yii::getAlias("@console/resources/db_dumps/group_persons.csv");
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                $i++;
                echo "=== \n";

                /* @var Person $person */
                $person = Person::findOne(['portal_uid' => $data[0]]);

                if (!$person) {
                    echo 'No: ' . $i . ' ' . $data[0] . "\n";
                    break;
                }

                $this->insert(StudentGroupLink::tableName(), [
                    'student_id' => $person->id,
                    'group_id' => $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
