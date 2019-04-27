<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\link\AppealCommissionMemberLink;

/**
 * AppealCommissionMemberSearch represents the model behind the search form of `common\models\link\AppealCommissionMemberLink`.
 */
class AppealCommissionMemberSearch extends AppealCommissionMemberLink
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'appeal_commission_id', 'member_id', 'role'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
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
        $query = AppealCommissionMemberLink::find();

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
            'appeal_commission_id' => $this->appeal_commission_id,
            'member_id' => $this->member_id,
            'role' => $this->role,
            'create_ts' => $this->create_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        return $dataProvider;
    }
}
