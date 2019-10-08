<?php

use common\models\TeacherCourse;
use common\models\organization\Group;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Группы';
?>

<div class="card-body skin-white">
	<?php foreach ($model->groups as $group):?>
        <?= Html::a($group->caption_current, ['view-required', 'teacher_course_id' => $model->id, 'group_id' => $group->id], ['class' => '']) ?> <br>
    <?php endforeach;?>
</div>