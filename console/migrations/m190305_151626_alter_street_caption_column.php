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
        $this->unsetFirstStreet();
        $this->alterColumn('public.street', 'caption', 'jsonb USING caption::jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /**
     * First street was imported just as an example
     * this methods removes it's name, and sets it content as JSON
     */
    private function unsetFirstStreet()
    {
        $first = \common\models\Street::findOne(1);
        if ($first) {
            $first->caption = '{"kk": "", "ru": ""}';
            $first->save();
        }
    }
}
