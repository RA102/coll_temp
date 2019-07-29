<?php

use common\models\person\Person;
use common\models\person\PersonCredential;
use yii\db\Migration;

/**
 * Class m190516_071548_insert_bolashak_credentials
 */
class m190516_071548_insert_bolashak_credentials extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return true;
        $this->insertCredentialsWithIIN();
        $this->insertCredentialsWithoutIIN();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    private function insertCredentialsWithIIN()
    {
        $file_path = Yii::getAlias("@console/resources/db_dumps/bolashak_iin.csv");
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (!is_numeric($data[1])) {
                    continue;
                }

                $person = Person::find()->where(['portal_uid' => $data[0]])->one();
                if ($person) {
                    $i++;
                    continue;
                }

                $this->update(Person::tableName(), ['portal_uid' => intval($data[0])], ['id' => $data[1]]);

                $credential = PersonCredential::find()->where(['indentity' => $data[2]])->one();
                if ($credential) {
                    $i++;
                    continue;
                }

                $this->insert(PersonCredential::tableName(), [
                    'person_id' => $data[1],
                    'indentity' => $data[2],
                ]);
            }
            echo "$i credentials exists\n";
            fclose($handle);
        }
    }

    private function insertCredentialsWithoutIIN()
    {
        $file_path = Yii::getAlias("@console/resources/db_dumps/bolashak_no_iin.csv");
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (!is_numeric($data[1])) {
                    continue;
                }

                $person = Person::find()->where(['portal_uid' => $data[0]])->one();
                if ($person) {
                    $i++;
                    continue;
                }

                $this->update(Person::tableName(), ['portal_uid' => intval($data[0])], ['id' => $data[1]]);

                $credential = PersonCredential::find()->where(['indentity' => $data[2]])->one();
                if ($credential) {
                    $i++;
                    continue;
                }

                $this->insert(PersonCredential::tableName(), [
                    'person_id' => $data[1],
                    'indentity' => $data[2],
                ]);
            }
            echo "$i credentials exists\n";
            fclose($handle);
        }
    }
}
