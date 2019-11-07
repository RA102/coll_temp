<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Institution;

/**
 * DisciplineSearch represents the model behind the search form of `common\models\Discipline`.
 */
class InstitutionDisciplineSearch extends InstitutionDiscipline
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'institution_id'], 'integer'],
            [['caption', 'slug', 'create_ts', 'update_ts', 'delete_ts', 'institution_id'], 'safe'],
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
        $query = InstitutionDiscipline::find();

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

        if (isset($this->institution_id)) {
            $query->andWhere([self::tableName().'.institution_id' => $this->institution_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
            'caption_current' => $this->caption_current,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'caption_current', $this->caption_current])
            ->andFilterWhere(['ilike', 'slug', $this->slug]);

        $query->andFilterWhere([
		    'or',
		    ['like', 'caption[\'ru\']', $this->caption_current],
		    ['like', 'caption[\'kk\']', $this->caption_current],
		]);

        return $dataProvider;
    }
}
