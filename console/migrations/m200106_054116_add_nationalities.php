<?php

use common\models\Nationality;
use yii\db\Migration;

/**
 * Class m200106_054116_add_nationalities
 */
class m200106_054116_add_nationalities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(Nationality::tableName(), ['name' => 'Казах/Казашка,Қазақ'], ['id' => 1]);
        $this->update(Nationality::tableName(), ['name' => 'Русский/Русская,Орыс'], ['id' => 2]);
        
        $this->insert(Nationality::tableName(), [ 'name' => 'Кореец/Кореянка,Кәріс', 'id' => 100, 'sort'=>100 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Немец/Немка,Неміс', 'id' => 101, 'sort'=>101 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Татарин/Татарка,Татар', 'id' => 104, 'sort'=>104 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Киргиз/Киргизка,Қырғыз', 'id' => 105, 'sort'=>105 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Узбек/Узбечка,Өзбек', 'id' => 106, 'sort'=>106 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Уйгур/Уйгурка,Ұйғыр', 'id' => 107, 'sort'=>107 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Туркмен/Туркменка,Түрікмен', 'id' => 108, 'sort'=>108 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Азербайджанин/Азербайджанка,Әзербайжа', 'id' => 109, 'sort'=>109 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Чеченец/Чеченка,Шешен', 'id' => 110, 'sort'=>110 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Грузин/Грузинка,Грузин', 'id' => 111, 'sort'=>111 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Таджик/Таджичка,Таджик', 'id' => 112, 'sort'=>112 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Ингуш/Ингушка,Ингуш', 'id' => 116, 'sort'=>116 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Осетин/Осетинка,Осентин', 'id' => 120, 'sort'=>120 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Кистинец/Кистинка,Кистин', 'id' => 121, 'sort'=>121 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Грек/Гречанка,Грек', 'id' => 122, 'sort'=>122 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Армянин/Армянка,Армян', 'id' => 124, 'sort'=>124 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Поляк/Полька,Поляк', 'id' => 118, 'sort'=>118 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Дунганец/Дунганка,Дунган', 'id' => 114, 'sort'=>114 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Чуваш/Чувашка,Чуваш', 'id' => 131, 'sort'=>131 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Лезгин/Лезгинка,Лезгин', 'id' => 132, 'sort'=>132 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Еврей/Еврейка,Еврей', 'id' => 130, 'sort'=>130 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Латчик,Латчик', 'id' => 139, 'sort'=>139 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Чех/Чешка,Чех', 'id' =>   3, 'sort'=>130 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Араб/Арабка,Араб', 'id' => 140, 'sort'=>140 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Молдован/Молдованка,Молдован', 'id' => 123, 'sort'=>123 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Удмурт/Удмуртка,Удмурт', 'id' => 143, 'sort'=>143 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Венгр/Венгерка,Венгр', 'id' => 144, 'sort'=>144 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Латыш/Латышка,Латыш', 'id' => 146, 'sort'=>146 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Калмык/Калмычка,Калмык', 'id' => 147, 'sort'=>147 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Карел/Карелка,Карел', 'id' => 148, 'sort'=>148 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Хакас/Хакаска,Хакас', 'id' => 149, 'sort'=>149 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Каракалпак/Каракалпачка,Қарақалпақ', 'id' => 142, 'sort'=>142 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Башкир/Башкирка,Башқұрт', 'id' => 113, 'sort'=>113 ]);
        
        
        $this->insert(Nationality::tableName(), [ 'name' => 'Финн/Финка,Финн', 'id' => 141, 'sort'=>141 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Поляк/Полячка,Поляк', 'id' => 117, 'sort'=>117 ]);
        
        $this->insert(Nationality::tableName(), [ 'name' => 'Монгол/Монголка,Монғол', 'id' => 115, 'sort'=>115 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Мариец/Марийка,Мари', 'id' => 125, 'sort'=>125 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Литовец/Литовка,Литвалық', 'id' => 127, 'sort'=>127 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Китаец/Китаянка,Қытай', 'id' => 128, 'sort'=>128 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Цыган/Цыганка,Сыған', 'id' => 129, 'sort'=>129 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Итальянец/Итальянка,Итальяндық', 'id' => 133, 'sort'=>133 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Болгарин/Болгарка,Болгар', 'id' => 134, 'sort'=>134 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Эстонец/Эстонка,Эстондық', 'id' => 135, 'sort'=>135 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Турок/Турчанка,Түрік', 'id' => 137, 'sort'=>137 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Аварец/Аварка,Авар', 'id' => 138, 'sort'=>138 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Японец/Японка,Жапон', 'id' => 145, 'sort'=>145 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Мордвин/Мордовка,Мордва', 'id' => 126, 'sort'=>126 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Украинец/Украинка,Украиндық', 'id' => 102, 'sort'=>102 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Француз/Француженка,Француз', 'id' => 150, 'sort'=>150 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Афганец/Афганка,Афганец', 'id' => 170, 'sort'=>170 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Иранец/Иранка,Иранец', 'id' => 171, 'sort'=>171 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Индус/Индуска,Индус', 'id' => 172, 'sort'=>172 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Курд/Курдянка,Курд', 'id' => 177, 'sort'=>177 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Гагауз,Гагауз', 'id' => 151, 'sort'=>151 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Ассириец/Ассирийка,Ассирияалық', 'id' => 178, 'sort'=>178 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Ногаец/Ногайка,Ноғай', 'id' => 201, 'sort'=>201 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Даргин/Даргинка,Даргин', 'id' => 202, 'sort'=>202 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Кумык/Кумычка,Кумык', 'id' => 203, 'sort'=>203 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Не указана,Көрсетілмеген', 'id' => 173, 'sort'=>3 ]);
        $this->insert(Nationality::tableName(), [ 'name' => 'Белорус/Белоруска,Белорус', 'id' => 103, 'sort'=>103 ]);
       
        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200106_054116_add_nationalities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200106_054116_add_nationalities cannot be reverted.\n";

        return false;
    }
    */
}
