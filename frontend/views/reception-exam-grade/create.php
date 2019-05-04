<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExamGrade */
/* @var $receptionGroup common\models\ReceptionGroup */
/* @var $receptionExam common\models\ReceptionExam */
/* @var $entrant common\models\person\Entrant */

$this->title = Yii::t('app', 'Create Reception Exam Grade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reception Exam Grades'), 'url' => ['index', 'reception_group_id' => $receptionGroup->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <p>
                    <b>Экзамен:</b> <?= $receptionExam->getFullName() ?>
                </p>
                <p>
                    <b>Абитуриент:</b> <?= $entrant->getFullName() ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $this->render('_form', [
                    'model' => $model,
                    'receptionGroup' => $receptionGroup,
                    'entrant' => $entrant,
                    'receptionExam' => $receptionExam,
                ]) ?>
            </div>
            <div class="col-md-6">
                <?php if ($model->historyWrapper): ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Дата выставления</th>
                            <th>Оценка</th>
                        </tr>
                        </thead>
                        <?php foreach ($model->historyWrapper as $history): ?>
                            <tr>
                                <td><?= $history->date ?? '' ?></td>
                                <td><?= $history->value ?? '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
