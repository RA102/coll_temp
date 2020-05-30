<?php

//use yii\widgets\DetailView;

use common\models\reception\AdmissionFiles;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AdmissionApplication */
?>

<?=GridView::widget([
    //'layout'       => "{items}\n{pager}",
    'dataProvider' => new ActiveDataProvider([
        'query' => AdmissionFiles::find()->where(['aa_id' => $model->id])->limit(20),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]),
    //'filterModel' => $searchModel,
    'formatter' => [
        'class' => '\yii\i18n\Formatter',
        'dateFormat' => 'dd.MM.yyyy',
        'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
    ],            
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'fio',
            'label' => Yii::t('app', 'Тип'),
            'value' => function ($model) {
                return $model->getDocTypeLabel();
            },
        ],
       
        [
            'attribute' => 'iin',
            'label' => '', 
            'value' => function ($model) {
                return \yii\helpers\Html::a('Просмотр', $model->url, ['class'=>'btn btn-primary', 'target' => '_blank']);
            },
            'format' => 'raw',
            
            //'filterOptions' => ['style' => 'width: 140px'],
        ],
       
    ],
]); ?>



<?= $this->render('_actions', compact('model'));