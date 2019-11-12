<?php

namespace frontend\search;

use common\models\Course;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * CourseSearch represents the model behind the search form of `common\models\public\Course`.
 */
class CourseSearch extends Course
{
    public $institution_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id', 'institution_discipline_id', 'status'], 'integer'],
            [['institution_id'], 'safe'],
            [['classes'], 'each', 'rule' => ['integer']],
            [['caption_ru', 'caption_kk'], 'string'],
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
        $query = Course::find();

        // add conditions that should always apply here

        if (isset($this->institution_id)) {
            $query->joinWith([
                'institutionDiscipline' => function (ActiveQuery $query) {
                    return $query->andWhere([
                        'institution_id' => Yii::$app->user->identity->institution->id,
                    ]);
                }
            ]);
        }

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
            'institution_discipline_id' => $this->institution_discipline_id,
            'caption' => $this->caption,
            'caption_ru' => $this->caption_ru,
            'caption_kk' => $this->caption_kk,
            'caption_current' => $this->caption_current,
            'classes' => $this->classes,
            'status' => $this->status,
            'create_ts' => $this->create_ts,
            'update_ts' => $this->update_ts,
            'delete_ts' => $this->delete_ts,
        ]);

        $query->andFilterWhere(['ilike', 'caption', $this->caption]);

        return $dataProvider;
    }
}
