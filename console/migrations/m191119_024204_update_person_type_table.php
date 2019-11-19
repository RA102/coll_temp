<?php

use yii\db\Migration;

/**
 * Class m191119_024204_update_person_type_table
 */
class m191119_024204_update_person_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('person.person_type', [
            'name' => 'director', 
            'group' => 1, 
            'caption' => '{"kk": "Директор", "ru": "Директор"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'chairman', 
            'group' => 1, 
            'caption' => '{"kk": "Председатель попечительского совета", "ru": "Председатель попечительского совета"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'director_deputy_academic', 
            'group' => 1, 
            'caption' => '{"kk": "Заместитель директора колледжа по учебной работе", "ru": "Заместитель директора колледжа по учебной работе"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'director_deputy_education', 
            'group' => 1, 
            'caption' => '{"kk": "Заместитель директора колледжа по учебно-воспитательной работе", "ru": "Заместитель директора колледжа по учебно-воспитательной работе"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'director_deputy_industrial', 
            'group' => 1, 
            'caption' => '{"kk": "Заместитель директора колледжа по учебно-производственной работе", "ru": "Заместитель директора колледжа по учебно-производственной работе"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'director_deputy_methodist', 
            'group' => 1, 
            'caption' => '{"kk": "Заместитель директора по научно-методической работе (заведующий методическим кабинетом, методист)", "ru": "Заместитель директора по научно-методической работе (заведующий методическим кабинетом, методист)"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'director_deputy_economic', 
            'group' => 1, 
            'caption' => '{"kk": "Заместитель директора по хозяйственной части", "ru": "Заместитель директора по хозяйственной части"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'admission_specialist', 
            'group' => 1, 
            'caption' => '{"kk": "Специалист приемной комиссии", "ru": "Специалист приемной комиссии"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'manager', 
            'group' => 1, 
            'caption' => '{"kk": "Менеджер", "ru": "Менеджер"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'psychologist', 
            'group' => 1, 
            'caption' => '{"kk": "Педагог-психолог", "ru": "Педагог-психолог"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'social_teacher', 
            'group' => 1, 
            'caption' => '{"kk": "Социальный педагог", "ru": "Социальный педагог"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'staff', 
            'group' => 1, 
            'caption' => '{"kk": "Персонал", "ru": "Персонал"}',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('person.person_type', ['name' => 'director']);
        $this->delete('person.person_type', ['name' => 'chairman']);
        $this->delete('person.person_type', ['name' => 'director_deputy_academic']);
        $this->delete('person.person_type', ['name' => 'director_deputy_education']);
        $this->delete('person.person_type', ['name' => 'director_deputy_industrial']);
        $this->delete('person.person_type', ['name' => 'director_deputy_methodist']);
        $this->delete('person.person_type', ['name' => 'director_deputy_economic']);
        $this->delete('person.person_type', ['name' => 'admission_specialist']);
        $this->delete('person.person_type', ['name' => 'manager']);
        $this->delete('person.person_type', ['name' => 'psychologist']);
        $this->delete('person.person_type', ['name' => 'social_teacher']);
        $this->delete('person.person_type', ['name' => 'staff']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_024204_update_person_type_table cannot be reverted.\n";

        return false;
    }
    */
}
