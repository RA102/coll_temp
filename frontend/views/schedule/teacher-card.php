<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = "Карта занятости " . $model->fullName;
?>

    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
		<?= Html::a('Полное расписание', ['/lesson/teacher-card','teacher_id' => $model->id,], ['class' => 'btn btn-primary']) ?>
    </div>


    <div class="lesson-index skin-white">
        <div class="card-body">
        	<table class="table table-condensed table-bordered table-striped">
        		<tr class="info">
        			<th>#</th>
        			<th>Время</th>
        			<?php foreach ($weekdays as $key => $value):?>
        				<th class="col-md-2"><?=$value?></th>
        			<?php endforeach;?>
	        		<?php while ($number <= 10):?>
	        			<tr>
	        				<th><?=$number?></th>
	        				<th>
	        					<?=$start_time[0] + $number - 1 . ':' . $start_time[1]?> <br>
	        					<?=$start_time[0] + $number - 1 . ':' . ($start_time[1] + $duration)?>
        					</th>
		        			<?php foreach ($weekdays as $key => $value):?>
		        				<?php if ($lessons):?>
		        						<td>
					        				<?php foreach ($lessons as $lesson):?>
					        					<?php if ($lesson->weekday == $key && $lesson->lesson_number == $number):?>
					        							<?=$lesson->teacherCourse->disciplineName?> <br>
					        							<?=$lesson->group->caption_current?> <br>
					        							(<?=$lesson->classroom->number?>)
					        							<?php if ($lesson->teacherCourse->status == 2):?>
					        								<br><small>(по выбору)</small>
					        							<?php endif;?>
					        					<?php endif;?>
						        			<?php endforeach;?>
		        						</td>
	    						<?php else:?>
			        				<td>
		        						<div style="height: 100%;width: 100%;">&nbsp</div>
			        				</td>
	        					<?php endif;?>
		        			<?php endforeach;?>
	        			</tr>
		    			<?php $number++;?>
	        		<?php endwhile;?>
        	</table>
        </div>
    </div>
