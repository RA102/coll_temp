<?php

use yii\db\Migration;

/**
 * Class m190310_033243_add_person_type_to_persons_table
 */
class m190310_033243_add_person_type_to_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('person.person_type', ['name', 'group', 'caption'], [
            ['superadmin', 4, '{"kk": "Супер администратор", "ru": "Супер администратор"}'],
            ['admin', 4, '{"kk": "Администратор", "ru": "Администратор"}'],
            ['student', 2, '{"kk": "Студент", "ru": "Студент"}'],
            ['teacher', 1, '{"kk": "Оқытушы", "ru": "Преподаватель"}'],
        ]);

        $this->addColumn("person.person", 'person_type', $this->string()->notNull()->defaultValue('superadmin'));
        $this->execute('ALTER TABLE person.person ALTER COLUMN person_type DROP DEFAULT');
        $this->createIndex(
            'person_type_name_idx',
            'person.person_type',
            'name',
            true
        );

        $this->addForeignKey(
            'fk_person_2_person_type',
            'person.person',
            'person_type',
            'person.person_type',
            'name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('person.person', 'person_type');
        $this->dropIndex('person.person_type_name_idx', 'person.person_type');
        $this->delete('person.person_type', [
            'name' => ['admin', 'student', 'superadmin', 'teacher']
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190310_033243_add_person_type_to_persons_table cannot be reverted.\n";

        return false;
    }
    */
}
