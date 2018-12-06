<?php

namespace common\models\person;

use Yii;

/**
 * This is the model class for table "person.person".
 *
 * @property int $id
 * @property int $status
 * @property string $nickname
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $birth_date
 * @property int $sex
 * @property int $nationality_id
 * @property string $iin
 * @property int $is_pluralist
 * @property int $birth_country_id
 * @property int $birth_city_id
 * @property string $birth_place
 * @property string $language
 * @property int $oid
 * @property int $alledu_id
 * @property int $alledu_server_id
 * @property int $pupil_id
 * @property int $owner_id
 * @property int $server_id
 * @property bool $is_subscribed
 * @property int $portal_uid
 * @property string $photo
 * @property int $type
 * @property string $create_ts
 * @property string $delete_ts
 * @property string $import_ts
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person.person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'sex', 'nationality_id', 'is_pluralist', 'birth_country_id', 'birth_city_id', 'oid', 'alledu_id', 'alledu_server_id', 'pupil_id', 'owner_id', 'server_id', 'portal_uid', 'type'], 'default', 'value' => null],
            [['status', 'sex', 'nationality_id', 'is_pluralist', 'birth_country_id', 'birth_city_id', 'oid', 'alledu_id', 'alledu_server_id', 'pupil_id', 'owner_id', 'server_id', 'portal_uid', 'type'], 'integer'],
            [['birth_date', 'create_ts', 'delete_ts', 'import_ts'], 'safe'],
            [['is_subscribed'], 'boolean'],
            [['nickname', 'firstname', 'lastname', 'middlename', 'iin'], 'string', 'max' => 100],
            [['birth_place', 'photo'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'nickname' => Yii::t('app', 'Nickname'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'sex' => Yii::t('app', 'Sex'),
            'nationality_id' => Yii::t('app', 'Nationality ID'),
            'iin' => Yii::t('app', 'Iin'),
            'is_pluralist' => Yii::t('app', 'Is Pluralist'),
            'birth_country_id' => Yii::t('app', 'Birth Country ID'),
            'birth_city_id' => Yii::t('app', 'Birth City ID'),
            'birth_place' => Yii::t('app', 'Birth Place'),
            'language' => Yii::t('app', 'Language'),
            'oid' => Yii::t('app', 'Oid'),
            'alledu_id' => Yii::t('app', 'Alledu ID'),
            'alledu_server_id' => Yii::t('app', 'Alledu Server ID'),
            'pupil_id' => Yii::t('app', 'Pupil ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'server_id' => Yii::t('app', 'Server ID'),
            'is_subscribed' => Yii::t('app', 'Is Subscribed'),
            'portal_uid' => Yii::t('app', 'Portal Uid'),
            'photo' => Yii::t('app', 'Photo'),
            'type' => Yii::t('app', 'Type'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'import_ts' => Yii::t('app', 'Import Ts'),
        ];
    }
}
