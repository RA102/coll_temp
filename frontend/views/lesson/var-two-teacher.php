<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Карта учителя 2 ') . $teacher->getFullname();
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="group-index skin-white">
    <div class="card-body">
    	<table class="table table-bordered table-striped">
    		<tr>
    			<th>№</th>
		    	<?php foreach ($weekdays as $key => $value) :?>
		    		<th><?=$value?></th>	
		    	<?php endforeach;?>
		    </tr>
	    	<?php for($i=1;$i<=10;$i++):?>
			    <tr>
			    	<td><?=$i?></td>
			    	<?php foreach ($weekdays as $key => $value) :?>
			    		<td>
			    			<?php foreach ($lessons as $lesson):?>
			    				<?php if ($lesson->number == $i && $lesson->weekday == $key):?>
			    					<?=$lesson->teacherCourse->getFullname()?> <br>
			    					<?=$lesson->group->caption_current?> <br>
			    					<?=$lesson->classroom->number?>
			    				<?php endif;?>
							<?php endforeach;?>
			    		</td>	
			    	<?php endforeach;?>
			    </tr>
		    <?php endfor;?>
		</table>
    </div>
</div>
