<?php

use yii\db\Migration;

/**
 * Class m190305_151626_alter_street_caption_column
 */
class m190305_151626_alter_street_caption_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('public.street', 'caption', 'jsonb USING caption::jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
