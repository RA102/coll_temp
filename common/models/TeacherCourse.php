<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\link\TeacherCourseGroupLink;
use common\models\organization\Group;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "teacher_course".
 *
 * @property int $id
 * @property int $course_id
 * @property int $teacher_id
 * @property string $type
 * @property string $start_ts
 * @property string $end_ts
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 * @property int $status
 *
 * @property Course $course
 * @property Lesson[] $lessons
 * @property Person $person // TODO should it be Employee?
 * @property Group[] $groups
 */
class TeacherCourse extends \yii\db\ActiveRecord
{
    const REQUIRED = 1; // обязательный предмет
    const OPTIONAL = 2; // по выбору

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'teacher_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'teacher_id', 'start_ts', 'end_ts'], 'required'],
            [['course_id', 'teacher_id'], 'default', 'value' => null],
            [['course_id', 'teacher_id', 'status'], 'integer'],
            [['start_ts', 'end_ts'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['teacher_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'type' => 'Способ',
            'groups' => 'Группы',
            'start_ts' => Yii::t('app', 'Teacher Course Start TS'),
            'end_ts' => Yii::t('app', 'Teacher Course End TS'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'status' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['teacher_course_id' => 'id'])->inverseOf('teacherCourse');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() // TODO should it be Employee?
    {
        return $this->hasOne(Person::class, ['id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupsVia()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])
            ->viaTable('link.teacher_course_group_link', ['teacher_course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->via('teacherCourseGroupLinks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourseGroupLinks()
    {
        return $this->hasMany(TeacherCourseGroupLink::class, ['teacher_course_id' => 'id'])
            ->andWhere([TeacherCourseGroupLink::tableName() . '.delete_ts' => null]);
    }

    public function getFullname()
    {
        return $this->course->caption_current . ' (' . $this->type . ')';
    }

    public function getDisciplineName()
    {
        return $this->course->institutionDiscipline->caption_current;
    }

    public function statusList()
    {
        $list = [
            '1' => 'Обязательный',
            '2' => 'По выбору',
        ];

        return $list;
    }

    public function getStatus($status)
    {
        $list = $this->statusList();

        if ($list[$status] !== null) {
            return $list[$status];
        }
        else return null;
    }

    public function getTypes()
    {
        $types = [
            'Теоретическое обучение' => [
                '1' => 'Лекция', 
                '2' => 'Семинар (ЛПЗ)', 
                '3' => 'Курсовая работа (проект)',
                '4' => 'Консультации',
            ],
            'Практика' => [
                '5' => 'Учебная практика',
            ],
            'Профессиональная практика' => [
                '6' => 'Технологическая', 
                '7' => 'Производственная',
            ], 
            'Промежуточная и итоговая аттестация' => [
                '8' => 'Контрольная работа',
                '9' => 'Зачёт',
                '10' => 'Экзамен',
            ],
            'Дипломная работы' =>[
                '11' => 'Написание и защита дипломной работы (проекта)',
            ],
            'Дополнительно' => [
                '12' => 'Факультативные курсы',
            ],
        ];

        return $types;
    }

    public function getType($key)
    {
        $types = $this->getTypes();

        if (array_key_exists($key, $types)) {
            return $types[$key];
        } else {
            foreach ($types as $type) {
                if (is_array($type)) {
                    if (array_key_exists($key, $type)) {
                        return $type[$key];
                    }
                }
            }
        }
    }
}
