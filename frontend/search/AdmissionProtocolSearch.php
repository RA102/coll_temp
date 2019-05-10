<?php

namespace frontend\search;

use common\models\reception\AdmissionProtocol;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdmissionProtocolSearch represents the model behind the search form of `common\models\reception\AdmissionProtocol`.
 */
class AdmissionProtocolSearch extends AdmissionProtocol
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'commission_id', 'status'], 'integer'],
            [['number', 'completion_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = AdmissionProtocol::find();

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
            'id'              => $this->id,
            'commission_id'   => $this->commission_id,
            'completion_date' => $this->completion_date,
            'status'          => $this->status,
            'create_ts'       => $this->create_ts,
            'update_ts'       => $this->update_ts,
            'delete_ts'       => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'number', $this->number]);

        return $dataProvider;
    }
}
