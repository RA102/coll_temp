<?php

use backend\models\forms\PersonCredentialForm;
use common\helpers\InstitutionHelper;
use common\helpers\PersonHelper;
use common\helpers\PersonTypeHelper;
use common\models\Nationality;
use common\models\person\Person;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */
/* @var $form backend\models\forms\PersonForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<div class="person-form">
    <?php $activeForm = ActiveForm::begin([
        'id' => 'js-update',
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend>ДАННЫЕ ПОЛЬЗОВАТЕЛЯ</legend>

                <?= $activeForm->field($form, 'firstname')->textInput(['maxlength' => true]) ?>

                <?= $activeForm->field($form, 'lastname')->textInput(['maxlength' => true]) ?>

                <?= $activeForm->field($form, 'middlename')->textInput(['maxlength' => true]) ?>

                <?= $activeForm->field($form, 'nickname')->textInput(['maxlength' => true]) ?>

                <?= $activeForm->field($form, 'iin')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999']) ?>

                <?= $activeForm->field($form, 'birth_date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>

                <?= $activeForm->field($form, 'sex')->widget(Select2::class, [
                    'data' => PersonHelper::getSexList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $activeForm->field($form, 'nationality_id')->widget(Select2::class, [
                    'data' => \yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>ДОПОЛНИТЕЛЬНО</legend>

                <?= $activeForm->field($form, 'institution_id')->widget(Select2::class, [
                    'data' => InstitutionHelper::getList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                ]) ?>

                <?= $activeForm->field($form, 'status')->widget(Select2::class, [
                    'data' => PersonHelper::getStatusList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                ]) ?>

                <?= $activeForm->field($form, 'type')->dropDownList([
                    Person::TYPE_UNDEFINED => '',
                    Person::TYPE_STUDENT => 'Обучающийся',
                    Person::TYPE_EMPLOYEE => 'Сотрудник',
                    Person::TYPE_ENTRANT => 'Абитуриент',
                ]) ?>

                <?= $activeForm->field($form, 'person_type')->widget(Select2::class, [
                    'data' => PersonTypeHelper::getList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                ]) ?>

                <?= $activeForm->field($form, 'portal_uid')->textInput() ?>

                <?php if ($model->isNewRecord): ?>
                    <?= $activeForm->field($form, 'indentity')->textInput() ?>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Назад'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!$model->isNewRecord): ?>
        <label>Логины:</label>
        <?php foreach ($model->personCredentials as $credential): ?>
            <p><?= $credential->indentity ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php
    $personCredentialForm = new PersonCredentialForm();
    Modal::begin([
        'header' => '<span class="modal-title">Добавить авторизационную запись</span>',
        'toggleButton' => [
            'label' => Yii::t('app', 'Добавить'),
            'class' => 'btn btn-primary'
        ]
    ]);
    $form = ActiveForm::begin(['action' => ['/person/create-credentials', 'id' => $model->id]]);
    echo $form->field($personCredentialForm, 'indentity')->label(false);
    echo Html::beginTag('div', ['class' => 'text-right']);
    echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);
    echo Html::endTag('div');
    ActiveForm::end();
    Modal::end();
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'iin',
            [
                'attribute' => 'status',
                'value' => function (Person $model) {
                    $statuses = \common\helpers\PersonHelper::getStatusList();
                    return $statuses[$model->status] ?? 'unknown';
                }
            ],
            'nickname',
            'firstname',
            'lastname',
            'middlename',
            'birth_date',
            'sex',
            'nationality_id',
            'is_pluralist',
            'birth_country_id',
            'birth_city_id',
            'birth_place',
            'language',
            'oid',
            'alledu_id',
            'alledu_server_id',
            'pupil_id',
            'owner_id',
            'server_id',
            'is_subscribed:boolean',
            'portal_uid',
            'photo',
            'type',
            'create_ts',
            'delete_ts',
            'import_ts',
            'person_type',
        ],
    ]) ?>

</div>
