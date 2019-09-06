<?php

/* @var $this yii\web\View */
/* @var $admissionApplicationForm \frontend\models\forms\AdmissionApplicationForm */
/* @var $specialities common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Добавить урок');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-create">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
    	'group' => $group,
        'weekdays' => $weekdays,
        'teacherCourses' => $teacherCourses,
        'teachers' => $teachers,
        'classrooms' => $classrooms,
        'model' => $model
    ]) ?>
</div>
