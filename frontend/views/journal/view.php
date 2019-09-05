<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал ' . $group->caption_current;
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Добавить', ['create', 'group_id' => $group->id], ['class' => 'title-action btn btn-primary']) ?>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <?php foreach ($journals as $journal):?>
                <tr>
                    <td><a href="single"><?=$journal->teacherCourse->course->caption_current?></a></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
