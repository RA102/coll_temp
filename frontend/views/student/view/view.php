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
    'formatter' => [
        'class' => '\yii\i18n\Formatter',
        'dateFormat' => 'dd.MM.yyyy',
        'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
    ],
    'attributes' => [
        [
            'attribute' => 'firstname',
            'value' => function (Student $model) {
                return $model->getFullName();
            }
        ],
        'iin',
        'birth_date:date',
        [
            'attribute' => 'sex',
            'value' => function (Student $model) {
                return PersonHelper::getSexList()[$model->sex];
            }
        ],
        [
            'attribute' => 'nationality_id',
            'value' => function (Student $model) {
                $nationality = $model->nationality;
                return $nationality !== null ? $nationality->name : '';
            }
        ],
        [
            'label' => 'Группа',
            'value' => function (Student $model) {
                try {
                    return $model->group->caption['ru'];
                } catch (Exception $e) {
                    return null;
                }
            }
        ]
    ],
]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>