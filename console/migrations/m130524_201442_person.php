<?php

use yii\db\Migration;

class m130524_201442_person extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE SCHEMA person;
        ");

        $this->createTable('person.person', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'nickname' => $this->string(100),
            'firstname' => $this->string(100),
            'lastname' => $this->string(100),
            'middlename' => $this->string(100),
            'birth_date' => $this->date(),
            'sex' => $this->smallInteger()->defaultValue(0),
            'nationality_id' => $this->smallInteger()->defaultValue(0),
            'iin' => $this->string(100),
            'is_pluralist' => $this->smallInteger()->defaultValue(0),
            'birth_country_id' => $this->bigInteger(),
            'birth_city_id' => $this->bigInteger(),
            'birth_place' => $this->string(255),
            'language' => $this->string(2)->defaultValue('ru'),
            'oid' => $this->bigInteger()->defaultValue(0),
            'alledu_id' => $this->bigInteger(),
            'alledu_server_id' => $this->bigInteger(),
            'pupil_id' => $this->bigInteger(),
            'owner_id' => $this->bigInteger(),
            'server_id' => $this->bigInteger(),
            'is_subscribed' => $this->boolean(),
            'portal_uid' => $this->bigInteger(),
            'photo' => $this->string(255),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
            'import_ts' => $this->timestamp(),
        ]);
    }

    public function down()
    {
        $this->dropTable('person.person');

        $this->execute("
            DROP SCHEMA person;
        ");
    }
}
