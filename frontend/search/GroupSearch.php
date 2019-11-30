<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\Group;

/**
 * GroupSearch represents the model behind the search form of `common\models\organization\Group`.
 */
class GroupSearch extends Group
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'speciality_id', 'max_class', 'class', 'education_form', 'education_pay_form', 'institution_id', 'parent_id', 'type', 'rating_system_id', 'based_classes'], 'integer'],
            [['caption', 'language', 'class_change_history', 'properties', 'start_ts', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['is_deleted'], 'boolean'],
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Group::find()
            ->andWhere([
                Group::tableName() . '.delete_ts' => null,
                'is_deleted' => false,
            ]);

        // add conditions that should always apply here

        $person = \Yii::$app->user->identity;

        if ($person->isTeacher()) {
            //$query->andWhere(['id' => '1037']);
            $query->joinWith('teachers');
            $query->andWhere(['person.person.id' => $person->id]);
            //$query->andWhere(['public.teacher_course.teacher_id' => $person->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'max_class' => $this->max_class,
            'class' => $this->class,
            'education_form' => $this->education_form,
            'education_pay_form' => $this->education_pay_form,
            'institution_id' => $this->institution_id,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'rating_system_id' => $this->rating_system_id,
            'based_classes' => $this->based_classes,
            'is_deleted' => $this->is_deleted,
            'start_ts' => $this->start_ts,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'language', $this->language])
            ->andFilterWhere(['ilike', 'class_change_history', $this->class_change_history])
            ->andFilterWhere(['ilike', 'properties', $this->properties]);

        return $dataProvider;
    }
}
