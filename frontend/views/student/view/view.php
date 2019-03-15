<?php

use common\helpers\PersonHelper;
use common\models\person\Student;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
?>

<?php $this->beginBlock('view-content') ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'firstname',
                    'value' => function(Student $model) {
                        return $model->getFullName();
                    }
                ],
                'iin',
                'birth_date',
                [
                    'attribute' => 'sex',
                    'value' => function(Student $model) {
                        return PersonHelper::getSexList()[$model->sex];
                    }
                ],
                [
                    'attribute' => 'nationality_id',
                    'value' => function(Student $model) {
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