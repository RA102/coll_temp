<?php

use common\helpers\PersonHelper;
use common\models\person\Student;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

$this->title = $model->firstname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="student-view">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'status',
                'nickname',
                'firstname',
                'lastname',
                'middlename',
                'birth_date',
                [
                    'attribute' => 'sex',
                    'value' => function(Student $model) {
                        return PersonHelper::getSexList()[$model->sex];
                    }
                ],
                'nationality_id',
                'iin',
                'birth_place',
                'language',
            ],
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>