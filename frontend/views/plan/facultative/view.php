<?php

use common\models\Facultative;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = $model->teacherCourse->disciplineName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Факультативные занятия'), 'url' => ['/plan/facultative']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-required">
    <?php if ($model !== null):?>
	<div class="card-head">
		<p>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'teacher_course_id',
                    'value' => function (Facultative $model) {
                        return $model->teacherCourse->disciplineName;
                    },
                ],
                [
                    'attribute' => 'group_id',
                    'value' => function (Facultative $model) {
                        return $model->group->caption_current;
                    },
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (Facultative $model) {
                        return $model->teacher->getFullname();
                    },
                ],
            ],
        ]) ?>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card-body skin-white">
				<h2>Планирумое кол-во часов</h2>
	            <?= Html::a(Yii::t('app', 'Update'), ['edit-facultative', 'teacher_course_id' => $model->teacherCourse->id, 'group_id' => $model->group_id], ['class' => 'btn btn-primary']) ?>
				<table class="table table-bordered">
					<tr>
						<th></th>
						<th>Семестр I</th>
						<th>Семестр II</th>
						<th>За год</th>
					</tr>
					<tr>
						<th>Лекции (ч)</th>
						<td><?=$model->hours[1]?></td>
						<td><?=$model->hours[2]?></td>
						<td><?=$model->forYear('lections_hours')?></td>
					</tr>
				</table>

		    </div>
		</div>
	</div>
    <?php else:?>
        <div class="card-body skin-white">
            <p>План отсутствует</p>
            <?= Html::a(Yii::t('app', 'Добавить'), ['edit-facultative', 'teacher_course_id' => $teacherCourse->id, 'group_id' => $group->id], ['class' => 'btn btn-alert']) ?>
        </div>
    <?php endif;?>
</div>