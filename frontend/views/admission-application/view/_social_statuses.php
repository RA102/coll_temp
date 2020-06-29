<?php

/* @var $this yii\web\View */

/* @var $model common\models\reception\AdmissionApplication */

use app\models\handbook\PersonSocialStatus;
    $soc_arr = $model->properties['social_statuses'];
    if (isset($soc_arr) && count($soc_arr)>0 && strlen($soc_arr[0]['name'])<1){
        $soc_arr = null;
    }

?>

<?= \yii\grid\GridView::widget([
    'summary'      => false,
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'models' => $soc_arr ?: []
    ]),
    'columns'      => [
        [
            'contentOptions' => ['style' => 'white-space: normal;'],
            'label'          => Yii::t('app', 'Наименование'),
            'value'          => function (array $socialStatusData) {
                $socialStatus = PersonSocialStatus::findOne($socialStatusData['name']);
                return $socialStatus ? $socialStatus->caption_current : null;
            },
        ],
        [
            'label' => Yii::t('app', 'Комментарий'),
            'value' => function (array $socialStatusData) {
                return $socialStatusData['comment'];
            },
        ],
        [
            'label' => Yii::t('app', 'Номер документа'),
            'value' => function (array $socialStatusData) {
                return $socialStatusData['document_number'];
            },
        ],
    ],
]) ?>

<?= $this->render('_actions', compact('model'));