<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Institution;
use yii\db\Expression;

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
            [['id', 'status', 'institution_id', 'types'], 'integer'],
            [['slug', 'create_ts', 'update_ts', 'delete_ts', 'institution_id'], 'safe'],
            ['caption_ru', 'string'],
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

        if (isset($this->types) && $this->types !== '') {
            $query->andFilterWhere(['types' => '{'.$this->types.'}']);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        if ($this->caption_ru) {

            $query->andWhere(new Expression('caption::json->>\'ru\' ilike \'%'. $this->caption_ru.'%\''));
                // new Expression('classes::int[] @> ARRAY[' . $this->classes . ']::int[]'
//        andFilterWhere(['ilike', 'caption::json->>\'ru\'', '%' . $this->caption_ru . '%'])

        }

        $query->andFilterWhere(['ilike', 'slug', $this->slug]);

        return $dataProvider;
    }
}
