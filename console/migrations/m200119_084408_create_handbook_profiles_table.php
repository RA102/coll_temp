<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rups_list`.
 */
class m200119_084405_create_rups_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('handbook.profiles', [
            'id' => $this->primaryKey(),
            'caption_ru' => $this->string(300),
            'caption_kz' => $this->string(300),
            'code' => $this->integer(20),
            'create_ts' => $this->dateTime(),
            'is_deleted' => $this->boolean(),
            'subjects' => $this->integer(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('handbook.profiles');
    }
}
