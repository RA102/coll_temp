<?php

namespace backend\search\handbook;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\handbook\Speciality;

/**
 * SpecialitySearch represents the model behind the search form of `common\models\handbook\Speciality`.
 */
class SpecialitySearch extends Speciality
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'parent_oid', 'type', 'server_id', 'subjects', 'institution_type'], 'integer'],
            [['code', 'caption', 'msko', 'gkz', 'create_ts'], 'safe'],
            [['is_deleted', 'is_working'], 'boolean'],
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
        $query = Speciality::find();

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
            'parent_id' => $this->parent_id,
            'parent_oid' => $this->parent_oid,
            'type' => $this->type,
            'server_id' => $this->server_id,
            'create_ts' => $this->create_ts,
            'is_deleted' => $this->is_deleted,
            'subjects' => $this->subjects,
            'is_working' => $this->is_working,
            'institution_type' => $this->institution_type,
        ]);

        $query->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'caption', $this->caption])
            ->andFilterWhere(['ilike', 'msko', $this->msko])
            ->andFilterWhere(['ilike', 'gkz', $this->gkz]);

        return $dataProvider;
    }
}
