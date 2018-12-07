<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\Institution;

/**
 * InstitutionSearch represents the model behind the search form of `common\models\organization\Institution`.
 */
class InstitutionSearch extends Institution
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'city_id', 'parent_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'oid', 'server_id', 'street_id', 'foundation_year', 'max_grade', 'status'], 'integer'],
            [['name', 'house_number', 'phone', 'fax', 'email', 'languages_iso', 'description', 'bin', 'website', 'info', 'domain', 'db_name', 'db_user', 'db_password', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['initialization'], 'boolean'],
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
        $query = Institution::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'parent_id' => $this->parent_id,
            'type_id' => $this->type_id,
            'educational_form_id' => $this->educational_form_id,
            'organizational_legal_form_id' => $this->organizational_legal_form_id,
            'oid' => $this->oid,
            'server_id' => $this->server_id,
            'street_id' => $this->street_id,
            'foundation_year' => $this->foundation_year,
            'max_grade' => $this->max_grade,
            'initialization' => $this->initialization,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'house_number', $this->house_number])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'fax', $this->fax])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'languages_iso', $this->languages_iso])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'bin', $this->bin])
            ->andFilterWhere(['ilike', 'website', $this->website])
            ->andFilterWhere(['ilike', 'info', $this->info])
            ->andFilterWhere(['ilike', 'domain', $this->domain])
            ->andFilterWhere(['ilike', 'db_name', $this->db_name])
            ->andFilterWhere(['ilike', 'db_user', $this->db_user])
            ->andFilterWhere(['ilike', 'db_password', $this->db_password]);

        return $dataProvider;
    }
}
