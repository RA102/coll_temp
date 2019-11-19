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
            'formatter' => [
                'class' => '\yii\i18n\Formatter',
                'dateFormat' => 'dd.MM.yyyy',
                'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
            ],
            'attributes' => [
                [
                    'attribute' => 'firstname',
                    'value' => function(Employee $model) {
                        return $model->getFullName();
                    }
                ],
                [
                    'attribute' => 'person_type',
                    'value' => function(Employee $model) {
                        return $model->getPersonTypeCaption();
                    },
                    'label' => 'Роль пользователя'
                ],
                'iin',
                'birth_date:date',
                [
                    'attribute' => 'sex',
                    'value' => function(Employee $model) {
                        return $model->getSex();
                    }
                ],
                [
                    'attribute' => 'nationality_id',
                    'value' => function(Employee $model) {
                        return $model->nationality->name ?? null;
                    }
                ],
                /*[
                    'attribute' => 'language',
                    'value' => function(Employee $model) {
                        return $model->getLanguage() ?? null;
                    }
                ],*/
                [
                    'attribute' => 'lang',
                    'value' => function(Employee $model) {
                        if ($model->lang) {
                            return implode(', ', array_map(function ($item) {
                                if ($item == 'kz') {
                                    $item = 'kk';
                                }
                                return \common\helpers\LanguageHelper::getLanguageList()[$item];
                            }, $model->lang));
                        }
                    },
                    'label' => 'Языки обучения'
                ],
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>