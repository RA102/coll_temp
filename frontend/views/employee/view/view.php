<?php

use common\helpers\PersonHelper;
use common\models\person\Employee;
use common\components\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
?>

<?php if ($model->id == $person->id):?>
    <?php $activeForm = ActiveForm::begin([
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],    
    ]); ?>

        <div class="row">
            <?= Html::tag('div', $activeForm->field($form2, 'current_institution')->dropDownList(
            ArrayHelper::map($institutions, 'id', 'name'), [
            'class' => 'form-control',
            'prompt' => ''
        ]), ['class' => 'col-md-9']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
<?php endif;?>

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