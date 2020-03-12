<?php

namespace app\models\rup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\rup\RupRoots;

/**
 * RupRootsSearch represents the model behind the search form of `app\models\rup\RupRoots`.
 */
class RupRootsSearch extends RupRoots
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rup_id', 'rup_year', 'status', 'create_userid', 'delete_userid', 'lastopen_userid', 'lastclose_userid', 'edu_form'], 'integer'],
            [['create_ts', 'delete_ts', 'lastopen_ts', 'lastclose_ts', 'captionRu', 'captionKz', 'lang', 'profile_code', 'spec_code'], 'safe'],
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
        $query = RupRoots::find();

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
            'rup_id' => $this->rup_id,
            'rup_year' => $this->rup_year,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'delete_ts' => $this->delete_ts,
            'lastopen_ts' => $this->lastopen_ts,
            'lastclose_ts' => $this->lastclose_ts,
            'create_userid' => $this->create_userid,
            'delete_userid' => $this->delete_userid,
            'lastopen_userid' => $this->lastopen_userid,
            'lastclose_userid' => $this->lastclose_userid,
            'edu_form' => $this->edu_form,
        ]);

        $query->andFilterWhere(['ilike', 'captionRu', $this->captionRu])
            ->andFilterWhere(['ilike', 'captionKz', $this->captionKz])
            ->andFilterWhere(['ilike', 'lang', $this->lang])
            ->andFilterWhere(['ilike', 'profile_code', $this->profile_code])
            ->andFilterWhere(['ilike', 'spec_code', $this->spec_code]);

        return $dataProvider;
    }
}
