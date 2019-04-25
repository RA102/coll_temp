<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */
/* @var $commission common\models\reception\Commission */

$this->title = Yii::t('app', 'Reception Exams');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <?php foreach ($institutionDisciplines as $institutionDiscipline): ?>
                    <td><?= $institutionDiscipline->caption_current ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <?php foreach ($commission->getDateRangeMap() as $date): ?>
            <tr>
                <td><?= $date ?></td>
                <td>123</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'commission_id',
                'institution_discipline_id',
                'teacher_id',
                'date_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
