<?php

namespace frontend\search;

use common\models\reception\AdmissionApplication;
use common\models\reception\Commission;
use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class AdmissionApplicationSearch extends AdmissionApplication
{
    public $status;
    public $iin;
    public $application_date;
    public $fio;

    protected $commission_id;

    /**
     * AdmissionApplicationSearch constructor.
     * @param Commission $commission
     * @param array $config
     */
    public function __construct(Commission $commission = null, array $config = [])
    {
        parent::__construct($config);

        $this->commission_id = $commission ? $commission->id : null;
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
            [['iin', 'fio', 'application_date'], 'string']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdmissionApplication::find()
            ->andWhere(['commission_id' => $this->commission_id]);

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
            'status' => $this->status,

        ]);

        if ($this->application_date != null) {
            $query->andWhere("properties ->> 'application_date' = :DATE", [':DATE' => (new DateTime($this->application_date))->format('d-m-Y')] );            
        }

        if ($this->iin != null) {
            $query->andWhere("properties ->> 'iin' = '" . $this->iin . "'");
        }

        if ($this->fio != null) {
            $query->andWhere("properties ->> 'lastname' ilike '" . $this->fio . "%'");            
        }


        return $dataProvider;
    }
}