<?php

namespace common\models\reception;

use common\models\link\CommissionMemberLink;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Person;
use common\models\ReceptionGroup;
use Yii;

/**
 * This is the model class for table "reception.commission".
 *
 * @property int $id
 * @property int $institution_id
 * @property array $caption
 * @property string $from_date
 * @property string $to_date
 * @property string $order_number
 * @property string $order_date
 * @property string $exam_start_date
 * @property string $exam_end_date
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property CommissionMemberLink[] $commissionMemberLinks
 * @property Institution $institution
 * @property InstitutionDiscipline[] $institutionDisciplines
 * @property Person[] $members
 * @property ReceptionGroup[] $receptionGroups
 */
class Commission extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_CLOSED = 10;

    public $caption_current;

    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.commission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => static::STATUS_ACTIVE],
            [['status'], 'integer'],
            [['caption', 'from_date', 'to_date', 'order_date', 'exam_start_date', 'exam_end_date'], 'safe'],
            [['order_number'], 'string', 'max' => 255],
            [['caption_ru', 'caption_kk'], 'string'],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];
        $this->caption_ru = $this->caption['ru'];
        $this->caption_kk = $this->caption['kk'];

        parent::afterFind();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                         => Yii::t('app', 'ID'),
            'institution_id'             => Yii::t('app', 'Institution'),
            'caption'                    => Yii::t('app', 'Caption'),
            'caption_ru'                 => Yii::t('app', 'Caption Ru'),
            'caption_kk'                 => Yii::t('app', 'Caption Kk'),
            'caption_current'            => Yii::t('app', 'Caption Current'),
            'from_date'                  => Yii::t('app', 'Commission From Date'),
            'to_date'                    => Yii::t('app', 'Commission To Date'),
            'order_number'               => Yii::t('app', 'Commission Order Number'),
            'order_date'                 => Yii::t('app', 'Commission Order Date'),
            'exam_start_date'            => Yii::t('app', 'Exam Start Date'),
            'exam_end_date'              => Yii::t('app', 'Exam End Date'),
            'status'                     => Yii::t('app', 'Status'),
            'create_ts'                  => Yii::t('app', 'Create Ts'),
            'delete_ts'                  => Yii::t('app', 'Delete Ts'),
            'institution_discipline_ids' => Yii::t('app', 'Institution Disciplines'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(Person::class, ['id' => 'member_id'])
            ->via('memberLinks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberLinks()
    {
        return $this->hasMany(CommissionMemberLink::class, ['commission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDisciplines()
    {
        return $this->hasMany(InstitutionDiscipline::class, ['id' => 'institution_discipline_id'])->viaTable('link.commission_discipline_link', ['commission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroups()
    {
        return $this->hasMany(ReceptionGroup::class, ['commission_id' => 'id']);
    }

    public function getDateRangeMap()
    {
        $dateMap = [];
        $current = strtotime($this->exam_start_date);
        $end = strtotime($this->exam_end_date);

        while ($current <= $end) {
            $stringDate = date('Y-m-d', $current);
            $dateMap[] = $stringDate;
            $current = strtotime('+1 days', $current);
        }

        return $dateMap;
    }
}
