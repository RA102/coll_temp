<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */
/* @var $commission common\models\reception\Commission */
/* @var $receptionExamsMap common\models\ReceptionExam[][] */

$this->title = Yii::t('app', 'Reception Exams');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <td></td>
                <?php foreach ($institutionDisciplines as $institutionDiscipline): ?>
                    <td><?= $institutionDiscipline->caption_current ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <?php foreach ($commission->getDateRangeMap() as $date): ?>
                <tr>
                    <td><?= $date ?></td>
                    <?php foreach ($institutionDisciplines as $institutionDiscipline): ?>
                        <td>
                            <a href="<?= \yii\helpers\Url::to([
                                'reception-exam/create',
                                'commission_id' => $commission->id,
                                'date' => $date,
                                'institution_discipline_id' => $institutionDiscipline->id
                            ]) ?>" class="btn btn-default btn-sm" target="_self">+</a>
                            <?php foreach ($receptionExamsMap[$date] ?? [] as $receptionExam): ?>
                                <?php if ($receptionExam->institution_discipline_id == $institutionDiscipline->id): ?>
                                    <div>
                                        <?= Html::a('<i class="fa fa-trash"></i>', [
                                            'reception-exam/delete',
                                            'id' => $receptionExam->id,
                                            'commission_id' => $receptionExam->commission_id,
                                        ], [
                                            'class' => 'btn btn-sm btn-danger',
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                        ]); ?>

                                        <?= $receptionExam->time ?>:

                                        <?= implode(', ', array_map(function (\common\models\ReceptionGroup $receptionGroup) {
                                            return "<span class='label label-default'>{$receptionGroup->caption_current}</span>";
                                        }, $receptionExam->receptionGroups)) ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
