<?php

namespace frontend\search;

use common\models\organization\Institution;
use common\models\reception\AdmissionApplication;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AdmissionApplicationSearch extends AdmissionApplication
{

    public $status;
    protected $institution_id;

    /**
     * AdmissionApplicationSearch constructor.
     * @param Institution $institution
     * @param array $config
     */
    public function __construct(Institution $institution, array $config = [])
    {
        parent::__construct($config);

        $this->institution_id = $institution->id;
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
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
     * @return array
     */
    public function rules()
    {
        return [
            ['status', 'integer'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdmissionApplication::find();

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

        $query->andFilterWhere([
            'institution_id' => $this->institution_id,
            'status'         => $this->status
        ]);

        return $dataProvider;
    }
}