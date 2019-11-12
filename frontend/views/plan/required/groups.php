<?php

use common\models\TeacherCourse;
use common\models\organization\Group;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $model->disciplineName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса')];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Обязательные дисциплины'), 'url' => ['/plan/required']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>

<div class="card-body skin-white">
	<table class="table table-bordered table-striped">
		<tr>
			<th>#</th>
			<th class="col-md-12">Группа</th>
		</tr>
		<?php foreach ($model->groups as $key => $group):?>
			<tr>
				<td><?=$key + 1?></td>
				<td>
			        <?= Html::a($group->caption_current, ['view-required', 'teacher_course_id' => $model->id, 'group_id' => $group->id], ['class' => '']) ?> <br>
			    </td>
			</tr>
	    <?php endforeach;?>
   	</table>
</div>