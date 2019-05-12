<?php

use common\helpers\ApplicationHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form frontend\models\forms\JournalForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $specialities common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Journal');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $activeForm = ActiveForm::begin([
    'action' => ['journal'],
    'method' => 'get',
]); ?>
<div class="card">
    <div class="card-header">
        <div>
            <h4>Сформировать журнал</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->field($form, 'education_form')->dropDownList(\common\helpers\EducationHelper::getEducationFormTypes(), [
                    'prompt' => Yii::t('app', 'Выбрать')
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $activeForm->field($form, 'education_pay_form')->dropDownList(\common\helpers\EducationHelper::getPaymentFormTypes(), [
                    'prompt' => Yii::t('app', 'Выбрать')
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->field($form, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList(), [
                    'prompt' => Yii::t('app', 'Выбрать')
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $activeForm->field($form, 'speciality_id')->widget(\kartik\select2\Select2::class, [
                    'data' => \yii\helpers\ArrayHelper::map(
                        $specialities,
                        'id',
                        'caption_current'
                    ),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Введите поисковый запрос'),
                    ],
                    'theme' => 'default',
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-right">
            <?= Html::submitButton(Yii::t('app', 'Сформировать'), ['class' => 'btn btn-success', 'name' => 'export', 'value' => 1]) ?>
            <?= Html::resetButton(Yii::t('app', 'Сбросить фильтр'), ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton(Yii::t('app', 'Отфильтровать'), ['class' => 'btn btn-success', 'name' => 'export', 'value' => 0]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<div class="card">
    <div class="card-header">
        <div>
            <h4>Заявления</h4>
        </div>
    </div>
    <div class="card-body">

        <?= GridView::widget([
            'layout' => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => Yii::t('app', 'Ф.И.О'),
                    'value' => 'person.fullname'
                ],
                [
                    'label' => Yii::t('app', 'Дата подачи'),
                    'value' => 'properties.application_date',
                ],
                'person.iin',
//                [
//                    'label' => Yii::t('app', 'Phone'),
//                    'value' => 'properties.phone',
//                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (\common\models\reception\AdmissionApplication $admissionApplication) {
                        $labelText = ApplicationHelper::$list[$admissionApplication->status];
                        $statusClass = (function () use ($admissionApplication) {
                            if ($admissionApplication->status === ApplicationHelper::STATUS_CREATED) {
                                return 'label label-secondary';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_ACCEPTED) {
                                return 'label label-success';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_DECLINED) {
                                return 'label label-danger';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_ENLISTED) {
                                return 'label label-success';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_DELETED) {
                                return 'label label-danger';
                            }
                            return 'label label-primary';
                        })();

                        return "<span class='{$statusClass}'>{$labelText}</span>";
                    }
                ],
            ],
        ]); ?>

    </div>
</div>
