<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\InstitutionApplication;

/**
 * InstitutionApplicationSearch represents the model behind the search form of `common\models\organization\InstitutionApplication`.
 */
class InstitutionApplicationSearch extends InstitutionApplication
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'city_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'status'], 'integer'],
            [['iin', 'email', 'phone', 'name', 'firstname', 'lastname', 'middlename', 'street', 'birth_date', 'house_number', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = InstitutionApplication::find();

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
            'sex' => $this->sex,
            'city_id' => $this->city_id,
            'type_id' => $this->type_id,
            'birth_date' => $this->birth_date,
            'educational_form_id' => $this->educational_form_id,
            'organizational_legal_form_id' => $this->organizational_legal_form_id,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'iin', $this->iin])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'firstname', $this->firstname])
            ->andFilterWhere(['ilike', 'lastname', $this->lastname])
            ->andFilterWhere(['ilike', 'middlename', $this->middlename])
            ->andFilterWhere(['ilike', 'street', $this->street])
            ->andFilterWhere(['ilike', 'house_number', $this->house_number]);

        return $dataProvider;
    }
}
