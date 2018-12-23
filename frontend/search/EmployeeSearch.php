<?php

namespace frontend\search;

use common\models\person\Employee;
use common\models\person\Person;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmployeeSearch represents the model behind the search form of `common\models\person\Employee`.
 */
class EmployeeSearch extends Employee
{
    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'status', 'sex', 'nationality_id', 'is_pluralist', 'birth_country_id', 'birth_city_id',
                    'oid', 'alledu_id', 'alledu_server_id', 'pupil_id', 'owner_id', 'server_id', 'portal_uid', 'type'
                ],
                'integer'
            ],
            [
                [
                    'nickname', 'firstname', 'lastname', 'middlename', 'birth_date', 'iin', 'birth_place',
                    'language', 'photo', 'create_ts', 'delete_ts', 'import_ts'
                ],
                'safe'],
            [['is_subscribed'], 'boolean'],
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
        $query = Employee::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (isset($this->status)) {
            if ($this->status == Person::STATUS_DELETED) {
                $query->andWhere(['NOT', ['delete_ts' => null]]);
            } else {
                $query->andFilterWhere(['status' => $this->status]);
                $query->andWhere(['delete_ts' => null]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birth_date' => $this->birth_date,
            'sex' => $this->sex,
            'nationality_id' => $this->nationality_id,
            'is_pluralist' => $this->is_pluralist,
            'birth_country_id' => $this->birth_country_id,
            'birth_city_id' => $this->birth_city_id,
            'oid' => $this->oid,
            'alledu_id' => $this->alledu_id,
            'alledu_server_id' => $this->alledu_server_id,
            'pupil_id' => $this->pupil_id,
            'owner_id' => $this->owner_id,
            'server_id' => $this->server_id,
            'is_subscribed' => $this->is_subscribed,
            'portal_uid' => $this->portal_uid,
            'type' => $this->type,
            'create_ts' => $this->create_ts,
            'delete_ts' => $this->delete_ts,
            'import_ts' => $this->import_ts,
        ]);

        $query->andFilterWhere(['ilike', 'nickname', $this->nickname])
            ->andFilterWhere(['ilike', 'firstname', $this->firstname])
            ->andFilterWhere(['ilike', 'lastname', $this->lastname])
            ->andFilterWhere(['ilike', 'middlename', $this->middlename])
            ->andFilterWhere(['ilike', 'iin', $this->iin])
            ->andFilterWhere(['ilike', 'birth_place', $this->birth_place])
            ->andFilterWhere(['ilike', 'language', $this->language])
            ->andFilterWhere(['ilike', 'photo', $this->photo]);

        return $dataProvider;
    }
}
