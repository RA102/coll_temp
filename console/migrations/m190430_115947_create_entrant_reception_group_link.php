<?php

use yii\db\Migration;

/**
 * Class m190430_115947_create_reception_group_link
 */
class m190430_115947_create_entrant_reception_group_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link.entrant_reception_group_link', [
            'id'                 => $this->primaryKey(),
            'entrant_id'         => $this->integer()->notNull(),
            'reception_group_id' => $this->integer()->notNull(),
            'create_ts'          => $this->timestamp()->notNull()->defaultExpression('now()'),
            'delete_ts'          => $this->timestamp(),
        ]);
        $this->addForeignKey('fk_entrant_reception_group_link_2_entrant',
            'link.entrant_reception_group_link',
            'entrant_id',
            'person.person',
            'id'
        );
        $this->addForeignKey('fk_entrant_reception_group_link_2_group',
            'link.entrant_reception_group_link',
            'reception_group_id',
            'reception.group',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('link.entrant_reception_group_link');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190430_115947_create_reception_group_link cannot be reverted.\n";

        return false;
    }
    */
}
