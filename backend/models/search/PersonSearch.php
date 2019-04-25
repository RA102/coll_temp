<?php

namespace backend\models\search;

use common\models\person\PersonCredential;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\person\Person;

/**
 * PersonSearch represents the model behind the search form of `common\models\person\Person`.
 */
class PersonSearch extends Person
{
    public $indentity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sex', 'nationality_id', 'is_pluralist', 'birth_country_id', 'birth_city_id', 'oid', 'alledu_id', 'alledu_server_id', 'pupil_id', 'owner_id', 'server_id', 'portal_uid', 'type'], 'integer'],
            [['nickname', 'firstname', 'lastname', 'middlename', 'birth_date', 'iin', 'birth_place', 'language', 'photo', 'create_ts', 'delete_ts', 'import_ts', 'person_type', 'indentity'], 'safe'],
            [['is_subscribed'], 'boolean'],
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
        $query = Person::find();

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
            Person::tableName() . '.id' => $this->id,
            Person::tableName() . '.status' => $this->status,
            Person::tableName() . '.birth_date' => $this->birth_date,
            Person::tableName() . '.sex' => $this->sex,
            Person::tableName() . '.nationality_id' => $this->nationality_id,
            Person::tableName() . '.is_pluralist' => $this->is_pluralist,
            Person::tableName() . '.birth_country_id' => $this->birth_country_id,
            Person::tableName() . '.birth_city_id' => $this->birth_city_id,
            Person::tableName() . '.oid' => $this->oid,
            Person::tableName() . '.alledu_id' => $this->alledu_id,
            Person::tableName() . '.alledu_server_id' => $this->alledu_server_id,
            Person::tableName() . '.pupil_id' => $this->pupil_id,
            Person::tableName() . '.owner_id' => $this->owner_id,
            Person::tableName() . '.server_id' => $this->server_id,
            Person::tableName() . '.is_subscribed' => $this->is_subscribed,
            Person::tableName() . '.portal_uid' => $this->portal_uid,
            Person::tableName() . '.type' => $this->type,
            Person::tableName() . '.create_ts' => $this->create_ts,
            Person::tableName() . '.delete_ts' => $this->delete_ts,
            Person::tableName() . '.import_ts' => $this->import_ts,
            Person::tableName() . '.person_type' => $this->person_type,
        ]);

        $query->andFilterWhere(['ilike', Person::tableName() . '.nickname', $this->nickname])
            ->andFilterWhere(['ilike', Person::tableName() . '.firstname', $this->firstname])
            ->andFilterWhere(['ilike', Person::tableName() . '.lastname', $this->lastname])
            ->andFilterWhere(['ilike', Person::tableName() . '.middlename', $this->middlename])
            ->andFilterWhere(['ilike', Person::tableName() . '.iin', $this->iin])
            ->andFilterWhere(['ilike', Person::tableName() . '.birth_place', $this->birth_place])
            ->andFilterWhere(['ilike', Person::tableName() . '.language', $this->language])
            ->andFilterWhere(['ilike', Person::tableName() . '.photo', $this->photo]);

        if ($this->indentity) {
            $query->joinWith('personCredentials')
                ->andWhere(['ilike', PersonCredential::tableName() . '.indentity', $this->indentity]);
        }

        return $dataProvider;
    }
}
