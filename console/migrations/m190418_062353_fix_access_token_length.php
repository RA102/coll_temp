<?php

use yii\db\Migration;

/**
 * Class m190418_062353_fix_access_token_length
 */
class m190418_062353_fix_access_token_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(\common\models\person\AccessToken::tableName(), [
            'token' => $this->text()->notNull(),
            'hash' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(\common\models\person\AccessToken::tableName(), [
            'token' => $this->string()->notNull(),
            'hash' => $this->string()
        ]);
    }
}
