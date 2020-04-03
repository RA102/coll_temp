<?php

namespace frontend\search;

use common\models\link\PersonInstitutionLink;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\person\Person;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\person\Student;
use yii\db\ActiveQuery;

/**
 * StudentSearch represents the model behind the search form of `common\models\person\Student`.
 */
class StudentSearch extends Student
{
    public $institution_id;
    public $group_id;
    public $withoutGroup = false;

    public $formName;

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
            [['id', 'status', 'sex', 'nationality_id', 'is_pluralist', 'birth_country_id', 'birth_city_id', 'oid', 'alledu_id', 'alledu_server_id', 'pupil_id', 'owner_id', 'server_id', 'portal_uid', 'type'], 'integer'],
            [['nickname', 'firstname', 'lastname', 'middlename', 'birth_date', 'iin', 'birth_place', 'language', 'photo', 'create_ts', 'delete_ts', 'import_ts', 'institution_id'], 'safe'],
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
        $query = Student::find();

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
                $query->andWhere(['NOT', [self::tableName().'.delete_ts' => null]]);
            } else {
                $query->andFilterWhere([self::tableName().'.status' => $this->status]);
                $query->andWhere([self::tableName().'.delete_ts' => null]);
            }
        }

        if (!empty($this->institution_id)) {
            $query->innerjoinWith('institutions');
            $query->andWhere([Institution::tableName().'.id' => $this->institution_id]);
        }

        if (!empty($this->group_id)) {
            $query->innerJoinWith('groups');
            $query->andFilterWhere(['link.student_group_link.group_id' => $this->group_id]);
            $query->andWhere(['IS', 'link.student_group_link.delete_ts', new \yii\db\Expression('NULL')]);
            $query->andWhere([Group::tableName().'.institution_id' => $this->institution_id]);
        }

        if ($this->withoutGroup) {

            if (empty($this->group_id)) {
                $query->joinWith(['groups' => function ($q) {
                    $q->andOnCondition(Group::tableName().'.institution_id =' . $this->institution_id);
                }]
            
                );
                //$query->Where([Group::tableName().'.institution_id' => $this->institution_id]);
            }
            $query->joinWith(['studentGroupLinks as sgl' => function ($q) {
                $q->andOnCondition('sgl.group_id = ' . Group::tableName().'.id');
            }], false, 'LEFT OUTER JOIN');
            //$query->andFilterWhere(['link.student_group_link.institution_id' => $this->institution_id]);
            
            $query->andWhere(['IS', 'sgl.id', new \yii\db\Expression('NULL')]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'person.person.id' => $this->id,
            'birth_date' => $this->birth_date,
            'sex' => $this->sex,
            'nationality_id' => $this->nationality_id,
            'is_pluralist' => $this->is_pluralist,
            'birth_country_id' => $this->birth_country_id,
            'birth_city_id' => $this->birth_city_id,
            'oid' => $this->oid,
            'alledu_id' => $this->alledu_id,
            'alledu_server_id' => $this->alledu_server_id,
            'pupil_id' => $this->pupil_id,
            'owner_id' => $this->owner_id,
            'server_id' => $this->server_id,
            'is_subscribed' => $this->is_subscribed,
            'portal_uid' => $this->portal_uid,
            'person.person.type' => $this->type,
            'create_ts' => $this->create_ts,
            'delete_ts' => $this->delete_ts,
            'import_ts' => $this->import_ts,
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
