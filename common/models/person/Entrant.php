<?php

namespace common\models\person;

use app\models\link\EntrantReceptionGroupLink;
use common\helpers\PersonTypeHelper;
use common\models\reception\AdmissionApplication;
use common\models\reception\CommissionMemberLink;
use common\models\ReceptionExam;
use common\models\ReceptionExamGrade;
use common\models\ReceptionGroup;

/**
 * This is the model class for table "person.person".
 *
 * @property ReceptionGroup $receptionGroup
 * @property ReceptionExamGrade[] $receptionExamGrades
 * @property ReceptionExamGrade[] $indexedReceptionExamGrades
 */
class Entrant extends Person
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->andWhere([
            static::tableName() . '.type' => Person::TYPE_ENTRANT,
        ]);
    }

    /**
     * @param $portal_uid
     * @param $firstname
     * @param $lastname
     * @param $middlename
     * @param $iin
     * @return Person
     */
    public static function add($portal_uid, $firstname, $lastname, $middlename, $iin): Person
    {
        $model = parent::add($portal_uid, $firstname, $lastname, $middlename, $iin);
        $model->type = Person::TYPE_ENTRANT;
        $model->person_type = PersonTypeHelper::PERSON_TYPE_ENTRANT;

        return $model;
    }

    public function init()
    {
        parent::init();

        $this->type = Person::TYPE_ENTRANT;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionApplication()
    {
        return $this->hasOne(AdmissionApplication::class, ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroup()
    {
        return $this->hasOne(ReceptionGroup::class, ['id' => 'reception_group_id'])
            ->viaTable('link.entrant_reception_group_link', ['entrant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionExamGrades()
    {
        return $this->hasMany(ReceptionExamGrade::class, ['entrant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndexedReceptionExamGrades()
    {
        return $this->hasMany(ReceptionExamGrade::class, ['entrant_id' => 'id'])
            ->indexBy('exam_id');
    }

    /**
     * @param array $receptionExams
     * @return bool
     */
    public function passedReceptionExams(array $receptionExams): bool
    {
        if (sizeof($receptionExams) == 0) {
            return false;
        }

        $entrantPassedReceptionExamIds = $this->getReceptionExamGrades()->select('exam_id')->column();
        $receptionExamIds = array_map(function (ReceptionExam $receptionExam) {
            return $receptionExam->id;
        }, $receptionExams);

        return sizeof($receptionExamIds) ===
            sizeof(array_intersect($receptionExamIds, $entrantPassedReceptionExamIds));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrantReceptionGroupLinks()
    {
        return $this->hasMany(EntrantReceptionGroupLink::class, ['entrant_id' => 'id']);
    }
}
