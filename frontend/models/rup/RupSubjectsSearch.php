<?php

namespace frontend\models\rup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\rup\RupSubjects;

/**
 * RupSubjectsSearch represents the model behind the search form of `frontend\models\rup\RupSubjects`.
 */
class RupSubjectsSearch extends RupSubjects
{

    /**
     * {@inheritdoc}
     */
//    public $notTime;
    public function rules()
    {
        return [
            [['id', 'id_sub_block', 'id_block', 'exam', 'control_work', 'offset', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time'], 'integer'],
//            [['notTime'], 'safe'],
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
    public function search($params,$rup_id)
    {
        $query = RupSubjects::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['id_block' => ['asc'=>['block_id'=>SORT_ASC],'desc'=>['block_id'=>SORT_DESC],'default'=>'asc']]]
        ]);

//        $dataProvider->sort->attributes['notTime'] =
//            [
//                'asc'=>['notTime'=>SORT_ASC],
//                'desc'=>['notTime'=>SORT_DESC],
//            ];

        $dataProvider->setSort([
            'attributes' => [
//                'id',
                'id_sub_block' => [
//                    'asc' => ['id_sub_block' => SORT_ASC],
//                    'desc' => ['id_sub_block' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'id_block' => [
//                    'asc' => ['id_block' => SORT_ASC],
//                    'desc' => ['id_block' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rup_id'=>$rup_id,
//                'sub-block.id'=>$this->subBlock->id
//            'id' => $this->id,
            'id_sub_block' => $this->id_sub_block,
            'id_block' => $this->id_block,
//            'exam' => $this->exam,
//            'control_work' => $this->control_work,
//            'offset' => $this->offset,
//            'time' => $this->time,
//            'teory_time' => $this->teory_time,
//            'lab_time' => $this->lab_time,
//            'production_practice_time' => $this->production_practice_time,
//            'one_sem_time' => $this->one_sem_time,
//            'two_sem_time' => $this->two_sem_time,
//            'three_sem_time' => $this->three_sem_time,
//            'four_sem_time' => $this->four_sem_time,
//            'five_sem_time' => $this->five_sem_time,
//            'six_sem_time' => $this->six_sem_time,
//            'seven_sem_time' => $this->seven_sem_time,
//            'eight_sem_time' => $this->eight_sem_time,

        ]);

        return $dataProvider;
    }
}
