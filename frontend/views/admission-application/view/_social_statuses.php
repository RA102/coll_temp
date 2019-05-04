<?php

/* @var $this yii\web\View */
/* @var $model common\models\educational_process\AdmissionApplication */
?>

<?= \yii\grid\GridView::widget([
    'summary'      => false,
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'models' => $model->properties['social_statuses']
    ]),
    'columns'      => [
        [
            'label' => Yii::t('app', 'Наименование'),
            'value' => function (array $socialStatusData) {
                return $socialStatusData['name'];
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