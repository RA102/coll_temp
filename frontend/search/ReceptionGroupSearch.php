<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReceptionGroup;

/**
 * ReceptionGroupSearch represents the model behind the search form of `common\models\ReceptionGroup`.
 */
class ReceptionGroupSearch extends ReceptionGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'speciality_id', 'education_form', 'commission_id', 'budget_places', 'commercial_places'], 'integer'],
            [['caption', 'language', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = ReceptionGroup::find();

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
            'speciality_id' => $this->speciality_id,
            'education_form' => $this->education_form,
            'commission_id' => $this->commission_id,
            'budget_places' => $this->budget_places,
            'commercial_places' => $this->commercial_places,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'language', $this->language]);

        return $dataProvider;
    }
}
