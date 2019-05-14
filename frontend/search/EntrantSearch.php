<?php

namespace frontend\search;

use common\models\person\Entrant;
use common\models\person\Person;
use common\models\reception\Commission;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * StudentSearch represents the model behind the search form of `common\models\person\Student`.
 */
class EntrantSearch extends Entrant
{
    public $commission_id;
    public $reception_group_id;
    public $withoutGroup = false;

    public $formName;

    /**
     * EntrantSearch constructor.
     * @param Commission $commission
     * @param array $config
     */
    public function __construct(Commission $commission = null, array $config = [])
    {
        parent::__construct($config);

        $this->commission_id = $commission ? $commission->id : null;
    }

    public function formName()
    {
        return $this->formName ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'status',
                    'sex',
                    'nationality_id',
                    'is_pluralist',
                    'birth_country_id',
                    'birth_city_id',
                    'oid',
                    'alledu_id',
                    'alledu_server_id',
                    'pupil_id',
                    'owner_id',
                    'server_id',
                    'portal_uid',
                    'type'
                ],
                'integer'
            ],
            [
                [
                    'nickname',
                    'firstname',
                    'lastname',
                    'middlename',
                    'birth_date',
                    'iin',
                    'birth_place',
                    'language',
                    'photo',
                    'create_ts',
                    'delete_ts',
                    'import_ts'
                ],
                'safe'
            ],
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
        $query = Entrant::find()->innerJoinWith([
            'admissionApplication' => function (ActiveQuery $query) {
                return $query->andWhere(['commission_id' => $this->commission_id]);
            }
        ]);

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

        if (isset($this->status)) {
            if ($this->status == Person::STATUS_DELETED) {
                $query->andWhere(['NOT', [self::tableName() . '.delete_ts' => null]]);
            } else {
                $query->andFilterWhere([self::tableName() . '.status' => $this->status]);
                $query->andWhere([self::tableName() . '.delete_ts' => null]);
            }
        }

        if (!empty($this->institution_id)) {
            $query->joinWith('institutions');
            $query->andFilterWhere(['person_institution_link.institution_id' => $this->institution_id]);
        }

        if (!empty($this->reception_group_id)) {
            $query->joinWith('receptionGroup');
            $query->andFilterWhere(['link.entrant_reception_group_link.reception_group_id' => $this->reception_group_id]);
            $query->andWhere(['is', 'link.entrant_reception_group_link.delete_ts', new \yii\db\Expression('null')]);
        }

        if ($this->withoutGroup) {
            $query->joinWith('receptionGroups', false, 'LEFT OUTER JOIN');
            // search without link, or with soft deleted link
            $query->andFilterWhere([
                'OR',
                ['IS', 'reception_group_id', new \yii\db\Expression('NULL')],
                ['IS NOT', 'link.entrant_reception_group_link.delete_ts', new \yii\db\Expression('NULL')]
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'person.person.id'   => $this->id,
            'birth_date'         => $this->birth_date,
            'sex'                => $this->sex,
            'nationality_id'     => $this->nationality_id,
            'is_pluralist'       => $this->is_pluralist,
            'birth_country_id'   => $this->birth_country_id,
            'birth_city_id'      => $this->birth_city_id,
            'oid'                => $this->oid,
            'alledu_id'          => $this->alledu_id,
            'alledu_server_id'   => $this->alledu_server_id,
            'pupil_id'           => $this->pupil_id,
            'owner_id'           => $this->owner_id,
            'server_id'          => $this->server_id,
            'is_subscribed'      => $this->is_subscribed,
            'portal_uid'         => $this->portal_uid,
            'person.person.type' => $this->type,
            'create_ts'          => $this->create_ts,
            'delete_ts'          => $this->delete_ts,
            'import_ts'          => $this->import_ts,
        ]);

        $query->andFilterWhere(['ilike', 'nickname', $this->nickname])
            ->andFilterWhere(['ilike', 'firstname', $this->firstname])
            ->andFilterWhere(['ilike', 'lastname', $this->lastname])
            ->andFilterWhere(['ilike', 'middlename', $this->middlename])
            ->andFilterWhere(['ilike', 'iin', $this->iin])
            ->andFilterWhere(['ilike', 'birth_place', $this->birth_place])
            ->andFilterWhere(['ilike', 'language', $this->language])
            ->andFilterWhere(['ilike', 'photo', $this->photo]);

        return $dataProvider;
    }
}
