<?php

use yii\db\Migration;

/**
 * Class m191029_044244_set_lang_column_with_language_value_in_person_table
 */
class m191029_044244_set_lang_column_with_language_value_in_person_table extends Migration
{
    private $tableName = 'person.person';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!isset($tableName->columns['lang'])) {
            $this->addColumn($this->tableName, 'lang', 'jsonb');
        }
        Yii::$app->db->createCommand(
            "UPDATE ".$this->tableName." 
            SET lang = json_build_array(language)
            WHERE person_type = 'teacher';"
        )->execute();
        //Yii::$app->db->createCommand("INSERT INTO ".$this->tableName."(lang) values (ru) WHERE language = 'ru' AND person_type = 'teacher';")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand(
            "ALTER TABLE ".$this->tableName." 
            DROP COLUMN IF EXISTS lang;"
        )->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191029_044244_set_lang_column_with_language_value_in_person_table cannot be reverted.\n";

        return false;
    }
    */
}
