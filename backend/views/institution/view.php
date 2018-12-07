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
                'country_id',
                'city_id',
                'parent_id',
                'type_id',
                'educational_form_id',
                'organizational_legal_form_id',
                'oid',
                'server_id',
                'street_id',
                'house_number',
                'phone',
                'fax',
                'email:email',
                'languages_iso',
                'description:ntext',
                'bin',
                'foundation_year',
                'website',
                'max_grade',
                'info:ntext',
                'domain',
                'db_name',
                'db_user',
                'db_password',
                'initialization:boolean',
                'status',
                'create_ts',
                'update_ts',
                'delete_ts',
            ],
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>