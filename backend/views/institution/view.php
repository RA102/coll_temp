<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Institution */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institutions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="institution-view">

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
                'id',
                'name',
                [
                    'attribute' => 'country_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->country->caption_current;
                    }
                ],
                [
                    'attribute' => 'city_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->city->caption_current;
                    }
                ],
                [
                    'attribute' => 'type_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->institutionType->caption_current;
                    }
                ],
                [
                    'attribute' => 'educational_form_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->educationalForm->caption_current;
                    }
                ],
                [
                    'attribute' => 'educational_form_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->organizationalLegalForm->caption_current;
                    }
                ],
                [
                    'attribute' => 'street_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->street->caption_current;
                    }
                ],
                'house_number',
                'phone',
                'fax',
                'email:email',
                'description:ntext',
                'bin',
                'foundation_year',
                'website',
                'max_grade',
                'info:ntext',
                [
                    'attribute' => 'status',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->getStatusValue();
                    }
                ],
                'create_ts',
            ],
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>