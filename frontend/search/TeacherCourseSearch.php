<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TeacherCourse;

/**
 * TeacherCourseSearch represents the model behind the search form of `common\models\TeacherCourse`.
 */
class TeacherCourseSearch extends TeacherCourse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'teacher_id'], 'integer'],
            [['type', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = TeacherCourse::find()->with([
            'person' /** @see TeacherCourse::getPerson() */
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
            'course_id' => $this->course_id,
            'teacher_id' => $this->teacher_id,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
