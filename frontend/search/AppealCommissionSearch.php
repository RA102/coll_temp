<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\reception\AppealCommission;

/**
 * AppealCommissionSearch represents the model behind the search form of `common\models\reception\AppealCommission`.
 */
class AppealCommissionSearch extends AppealCommission
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'commission_id'], 'integer'],
            [['caption', 'from_date', 'to_date', 'order_number', 'order_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = AppealCommission::find();

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
            'commission_id' => $this->commission_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'order_date' => $this->order_date,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'order_number', $this->order_number]);

        return $dataProvider;
    }
}
