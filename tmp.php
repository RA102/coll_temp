<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServiceCharges;

/** * ServiceChargesSearch represents the model behind the search form about `app\models\ServiceCharges`. */
class ServiceChargesSearch extends ServiceCharges
{
    /** * @inheritdoc */
    public function attributes()
    { // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['serviceName.services']);
    }

    public function rules()
    {
        return [[['id'], 'integer'], [['charges_cash', 'charges_cashless'], 'number'], [['id', 'serviceName.services', 'room_category'], 'safe'],];
    }

    /** * @inheritdoc */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params * * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ServiceCharges::find();
        $dataProvider = new ActiveDataProvider(['query' => $query,]);
        $dataProvider->sort->attributes['serviceName.services'] = ['asc' => ['serviceName.services' => SORT_ASC], 'desc' => ['serviceName.services' => SORT_DESC],];
        $query->joinWith(['serviceName']);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'service_name' => $this->service_name,
            'room_category' => $this->room_category,
            'charges_cash' => $this->charges_cash,
            'charges_cashless' => $this->charges_cashless,
            ]) ->andFilterWhere([
                'LIKE', 'serviceName.services',
            $this->getAttribute('serviceName.services')]);
        return $dataProvider;
    }
}
