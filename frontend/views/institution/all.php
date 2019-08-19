<?php
use yii\grid\GridView;

$this->title = Yii::t('app', 'Institutions');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="institution-list student-block">
        <?= GridView::widget([
            'layout' => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'formatter' => [
                'class' => '\yii\i18n\Formatter',
                'dateFormat' => 'dd.MM.yyyy',
                'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ]
        ]); ?>
</div>