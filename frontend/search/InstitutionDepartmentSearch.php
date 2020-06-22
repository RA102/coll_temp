<?php

namespace frontend\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\organization\InstitutionDepartment;
use common\models\organization\Institution;

/**
 * DepartmentSearch represents the model behind the search form of `common\models\Department`.
 */
class InstitutionDepartmentSearch extends InstitutionDepartment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'institution_id'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts', 'institution_id'], 'safe'],
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
        $query = InstitutionDepartment::find();

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
            //'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', json_encode('caption'), $this->caption]);
           // ->andFilterWhere(['ilike', 'slug', $this->slug]);

        $query->andWhere(['is', 'delete_ts', null]);

        return $dataProvider;
    }
}
