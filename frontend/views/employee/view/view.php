<?php

use common\helpers\PersonHelper;
use common\models\person\Employee;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
?>

<?php $this->beginBlock('view-content') ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'firstname',
                    'value' => function(Employee $model) {
                        return $model->getFullName();
                    }
                ],
                'iin',
                'birth_date',
                [
                    'attribute' => 'sex',
                    'value' => function(Employee $model) {
                        return PersonHelper::getSexList()[$model->sex];
                    }
                ],
                [
                    'attribute' => 'nationality_id',
                    'value' => function(Employee $model) {
                        return $model->nationality->name;
                    }
                ],
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>