<?php

namespace frontend\search;

use common\models\TeacherCourse;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Lesson;
use yii\db\ActiveQuery;

/**
 * LessonSearch represents the model behind the search form of `common\models\Lesson`.
 */
class LessonSearch extends Lesson
{
    public $group_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'teacher_course_id', 'teacher_id', 'duration'], 'integer'],
            [['date_ts', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['group_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Lesson::find()->joinWith([
            /** @see Lesson::getTeacherCourse() */
            'teacherCourse' => function (ActiveQuery $query) {
                /** @see TeacherCourse::getGroups() */
                return $query
                    ->joinWith([
                        // For group_id filtration
                        'groups' => function (ActiveQuery $query) {
                            return $query->andFilterWhere([
                                'group.id' => $this->group_id
                            ]);
                        }
                    ], false)
                    ->with([
                        // For group name display (in fullcalendar)
                        'groups',
                    ]);
            }
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'teacher_course_id' => $this->teacher_course_id,
            'teacher_id' => $this->teacher_id,
            'date_ts' => $this->date_ts,
            'duration' => $this->duration,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        return $dataProvider;
    }
}
