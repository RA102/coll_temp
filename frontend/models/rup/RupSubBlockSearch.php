<?php

namespace frontend\models\rup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\rup\RupSubBlock;

/**
 * RupSubBlockSearch represents the model behind the search form of `frontend\models\rup\RupSubBlock`.
 */
class RupSubBlockSearch extends RupSubBlock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'block_id'], 'integer'],
            [['code', 'name','block'], 'safe'],
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
    public function search($params,$rup_id)
    {
        $query = RupSubBlock::find();

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
        $query->joinWith('block');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'block_id' => $this->block_id,
        ]);

        $query->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['rup_sub_block.rup_id'=> $rup_id]);
//            ->andFilterWhere(['>', 'rup_sub_block.rup_id', 0]);

        return $dataProvider;
    }
}