<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $group common\models\organization\Group */
/* @var $teacherCourses common\models\TeacherCourse[] */
/* @var $teachers common\models\person\Employee[] */
/* @var $classrooms common\models\organization\Classroom[] */
/* @var $searchModel frontend\search\LessonSearch */

$this->title = Yii::t('app', 'Group Lessons') . ': ' . $group->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['groups']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
    </div>


    <div class="lesson-index skin-white">
        <div class="card-body">
        	<table class="table table-condensed table-bordered">
        		<tr>
        			<th>#</th>
        			<th>пн</th>
        			<th>вт</th>
        			<th>ср</th>
        			<th>чт</th>
        			<th>пт</th>
        			<th>сб</th>
        		</tr>
        		<tr>
        			<th>1</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>2</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>3</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>4</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>5</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>6</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>7</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>8</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>9</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<th>10</th>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        	</table>
        </div>
    </div>
