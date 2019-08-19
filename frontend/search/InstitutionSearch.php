<?php

namespace frontend\search;

use common\forms\InstitutionForm;
use common\models\organization\Institution;
use common\services\organization\InstitutionService;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class InstitutionSearch extends Institution
{
	protected $institution_id;
    public $commission_id;

    public function formName()
    {
        return '';
    }

	public function __construct(Institution $institution, array $config = [])
    {
        parent::__construct($config);

        $this->institution_id = $institution->id;
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
        $query = Institution::find();

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

        return $dataProvider;
    }
}

?>