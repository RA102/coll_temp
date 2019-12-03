<?php

namespace frontend\search;

use common\models\organization\InstitutionSpecialityInfo;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * InstitutionSpecialityInfoSearch represents the model behind the search form of `common\models\handbook\InstitutionSpecialityInfo`.
 */
class InstitutionSpecialityInfoSearch extends InstitutionSpecialityInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'institution_id', 'status', 'default_grade', 'parent_id', 'academic_year_id', 'oid', 'server_id'], 'integer'],
            [['create_ts', 'code'], 'safe'],
            [['is_deleted'], 'boolean'],
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
        $query = InstitutionSpecialityInfo::find();

        // add conditions that should always apply here

        //if (isset($this->is_deleted)) {
            $query->andWhere([self::tableName().'.is_deleted' => false]);
        //}

        $query->joinWith(['speciality']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['code'] = [
	        'asc' => ['handbook.speciality.code' => SORT_ASC],
	        'desc' => ['handbook.speciality.code' => SORT_DESC],
	    ];

        $dataProvider->sort->attributes['caption'] = [
	        'asc' => ['handbook.speciality.caption' => SORT_ASC],
	        'desc' => ['handbook.speciality.caption' => SORT_DESC],
	    ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'institution_id' => $this->institution_id,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'is_deleted' => $this->is_deleted,
            'default_grade' => $this->default_grade,
            'parent_id' => $this->parent_id,
            'academic_year_id' => $this->academic_year_id,
            'oid' => $this->oid,
            'server_id' => $this->server_id,
        ]);

        $query->andFilterWhere(['ilike', 'handbook.speciality.code', $this->code]);

        return $dataProvider;
    }
}
