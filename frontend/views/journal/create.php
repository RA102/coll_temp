<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $specialities \common\models\handbook\Speciality[] */

$this->title = 'Журнал группы ' . $group->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Журнал</h1>
<table class="table table-bordered">
	<tr>
		<th>Группа</th>
		<td><?=$group->caption_current?></td>
	</tr>
	<tr>
		<th>Дата</th>
		<td><?=$date?></td>
	</tr>
	<tr>
		<th>Предмет</th>
		<td><?=$teacherCourse->course->institutionDiscipline->caption_current?></td>
	</tr>
	<tr>
		<th>Преподаватель</th>
		<td><?=$teacherCourse->person->getFullname()?></td>
	</tr>
	<tr>
		<th>Тип журнала</th>
		<td><?=$types[$type]?></td>
	</tr>
</table>
<?php $this->beginBlock('content') ?>
<div class="journal-create">

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $types[$type],
        'group' => $group,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
