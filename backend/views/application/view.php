<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionApplication */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="institution-application-view">

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
                'iin',
                'sex',
                'email:email',
                'phone',
                'name',
                'city_id',
                'type_id',
                'firstname',
                'lastname',
                'middlename',
                'street',
                'birth_date',
                'house_number',
                'educational_form_id',
                'organizational_legal_form_id',
                'create_ts',
                'update_ts',
            ],
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>