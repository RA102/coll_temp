<?php
namespace common\models\person;

use Yii;
use yii\db\ActiveRecord;

/**
 * Пользователь
 *
 * @property integer   $id                               - идентификатор
 * @property integer   $status                           - состояние
 * @property string    $nickname                         - ник
 * @property string    $firstname                        - имя
 * @property string    $lastname                         - фамилия
 * @property string    $middlename                       - отчество
 * @property string    $birth_date                       - дата рождения
 * @property integer   $sex                              - пол
 * @property integer   $nationality_id                   - иденификатор национальности
 * @property integer   $iin                              - ИИН
 * @property integer   $is_pluralist                     - признак совместитель
 * @property integer   $birth_country_id                 - страна
 * @property integer   $birth_city_id                    - населенный пункт
 * @property string    $birth_place                      - место рождения
 * @property string    $language                         - язык который предпочитает пользователь в формате ISO
 * @property integer   $oid                              - внешний идентификатор
 * @property integer   $alledu_id                        - идентификатор всеобуча
 * @property integer   $alledu_server_id                 - идентификатор сервера всеобуча
 * @property integer   $pupil_id                         - идентификатор ученика
 * @property integer   $owner_id                         - идентификатор владельца
 * @property integer   $server_id                        - идентификатор сервера
 * @property boolean   $is_subscribed                    - подпись на рассылку писем
 * @property integer   $portal_uid                       - идентификатор пользователя на портале
 * @property string    $photo                            - фото пользователя
 * @property string    $create_ts                        - дата создания
 * @property string    $delete_ts                        - дата удаления
 * @property string    $import_ts                        - дата импорта
 */
class Person extends ActiveRecord
{
    public static function tableName()
    {
        return 'person.person';
    }
}
