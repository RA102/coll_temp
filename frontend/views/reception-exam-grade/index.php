<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $receptionGroup common\models\ReceptionGroup */
/* @var $receptionExams common\models\ReceptionExam[] */
/* @var $entrants common\models\person\Entrant[] */
/* @var $gradeMap array */

$this->title = Yii::t('app', 'Reception Exam Grades');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <td></td>
                <?php foreach ($receptionExams as $receptionExam): ?>
                    <td><?= $receptionExam->getFullName() ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <?php foreach ($entrants as $entrant): ?>
                <tr>
                    <td><?= $entrant->getFullName() ?></td>
                    <?php foreach ($receptionExams as $receptionExam): ?>
                        <td>
                            <a href="<?= \yii\helpers\Url::to([
                                'reception-exam-grade/create',
                                'reception_group_id' => $receptionGroup->id,
                                'entrant_id' => $entrant->id,
                                'exam_id' => $receptionExam->id,
                            ]) ?>" target="_self"><span class="glyphicon glyphicon-pencil"></span></a>
                            &nbsp;
                            <?php if (isset($gradeMap[$entrant->id][$receptionExam->id])): ?>
                                <?= $gradeMap[$entrant->id][$receptionExam->id] ?>
                            <?php endif ?>

<!--                            --><?php //foreach ($receptionExamsMap[$date] ?? [] as $receptionExam): ?>
<!--                                --><?php //if ($receptionExam->institution_discipline_id == $institutionDiscipline->id): ?>
<!--                                    <div>-->
<!--                                        --><?//= Html::a('<i class="fa fa-trash"></i>', [
//                                            'reception-exam/delete',
//                                            'id' => $receptionExam->id,
//                                            'commission_id' => $receptionExam->commission_id,
//                                        ], [
//                                            'class' => 'btn btn-sm btn-danger',
//                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                                            'data-method' => 'post',
//                                        ]); ?>
<!---->
<!--                                        --><?//= $receptionExam->time ?><!--:-->
<!---->
<!--                                        --><?//= implode(', ', array_map(function (\common\models\ReceptionGroup $receptionGroup) {
//                                            return "<span class='label label-default'>{$receptionGroup->caption_current}</span>";
//                                        }, $receptionExam->receptionGroups)) ?>
<!--                                    </div>-->
<!--                                --><?php //endif; ?>
<!--                            --><?php //endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>