<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Discipline;

/**
 * DisciplineSearch represents the model behind the search form of `common\models\Discipline`.
 */
class DisciplineSearch extends Discipline
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['caption', 'slug', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
        $query = Discipline::find();

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
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'slug', $this->slug]);

        return $dataProvider;
    }
}
