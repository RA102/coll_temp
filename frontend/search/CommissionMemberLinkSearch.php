<?php

namespace frontend\search;

use common\models\link\CommissionMemberLink;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommissionMemberLinkSearch represents the model behind the search form of `common\models\link\CommissionMemberLink`.
 */
class CommissionMemberLinkSearch extends CommissionMemberLink
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'member_id', 'role', 'commission_id'], 'integer'],
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
        $query = CommissionMemberLink::find();

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
            'role' => $this->role,
            'member_id' => $this->member_id,
            'commission_id' => $this->commission_id,
        ]);

        return $dataProvider;
    }
}
