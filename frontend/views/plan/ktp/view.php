<?php

use common\models\Ktp;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = 'Календарно-тематический план';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-required">
	<div class="card-body skin-white">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update-required', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete-reuired', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('app', 'КТП'), ['ktp', 'id' => $model->id, 'type' => 'required'], ['class' => 'btn btn-alert']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'discipline_id',
                    'value' => function (Ktp $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                    'attribute' => 'group_id',
                    'value' => function (Ktp $model) {
                        return $model->group->caption_current;
                    },
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (Ktp $model) {
                        return $model->teacher->getFullname();
                    },
                ],
            ],
        ]) ?>

    </div>
</div>