<?php

namespace frontend\models\rup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\rup\RupModule;

/**
 * RupModuleSearch represents the model behind the search form of `frontend\models\rup\RupModule`.
 */
class RupModuleSearch extends RupModule
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year', 'status', 'study_form', 'profile_id', 'spec_id', 'level_id', 'study_time'], 'integer'],
            [['create', 'update_ts', 'caption_ru', 'caption_kz', 'profession_code'], 'safe'],
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
        $query = RupModule::find();

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
            'year' => $this->year,
            'status' => $this->status,
            'create' => $this->create,
            'update_ts' => $this->update_ts,
            'study_form' => $this->study_form,
            'profile_id' => $this->profile_id,
            'spec_id' => $this->spec_id,
            'level_id' => $this->level_id,
            'study_time' => $this->study_time,
        ]);

        $query->andFilterWhere(['ilike', 'caption_ru', $this->caption_ru])
            ->andFilterWhere(['ilike', 'caption_kz', $this->caption_kz])
            ->andFilterWhere(['ilike', 'profession_code', $this->profession_code]);

        return $dataProvider;
    }
}
