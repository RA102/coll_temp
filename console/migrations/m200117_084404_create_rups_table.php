<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200117_084404_create_rups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rup_roots', [
            'rup_id' => $this->primaryKey(),
            'rup_year' => $this->smallinteger(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'create_ts' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'delete_ts' => $this->dateTime()->null(),
            'lastopen_ts' => $this->dateTime()->null(),
            'lastclose_ts' => $this->dateTime()->null(),

            'create_userid' => $this->bigInteger(),
            'delete_userid' => $this->bigInteger(),
            'lastopen_userid' => $this->bigInteger(),
            'lastclose_userid' => $this->bigInteger(),

            'captionRu' => $this->string()->null(),
            'captionKz' => $this->string()->null(),
            'lang' => $this->string(6)->null(),
            'profile_code' => $this->string()->null(),
            'spec_code' => $this->string()->null(),
            'edu_form' => $this->integer()->null(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rup_roots');
    }
}
