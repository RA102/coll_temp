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
            <?php if ($model->isNew()) { ?>
                <?= Html::a(Yii::t('app', 'Approve'), ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Reject'), ['reject', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?php } ?>
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
                [
                    'attribute' => 'sex',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->getSex();
                    }
                ],
                'email:email',
                'phone',
                'name',
                [
                    'attribute' => 'city_id',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->city->caption_current;
                    }
                ],
                [
                    'attribute' => 'type_id',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->institutionType->caption_current;
                    }
                ],
                'firstname',
                'lastname',
                'middlename',
                [
                    'attribute' => 'street',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->streetModel->caption_current ?? null;
                    }
                ],
                'birth_date',
                'house_number',
                [
                    'attribute' => 'educational_form_id',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->educationalForm->caption_current;
                    }
                ],
                [
                    'attribute' => 'organizational_legal_form_id',
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->organizationalLegalForm->caption_current;
                    }
                ],
                'create_ts',
                'update_ts',
            ],
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>