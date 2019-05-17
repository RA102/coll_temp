<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $model common\models\reception\AdmissionApplication */
/* @var $receiptForm \frontend\models\reception\admission_application\ReceiptForm */

$this->title = Yii::t('app', 'Заявление') . " №{$model->id}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
    <div style="display: flex;">
        <div>
            <h1><?= $this->title ?></h1>
        </div>
        <div style="text-align: right; flex: 1">
            <?= Html::button(Yii::t('app', 'Расписка'), [
                'class'       => 'btn btn-primary',
                'data-toggle' => 'modal',
                'data-target' => '#admission-application-receipt-modal',
                'disabled'    => !$model->isAccepted()
            ]) ?>
            <?= Html::a(Yii::t('app', 'Сменить статус'), ['change-status', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>
        </div>

    </div>

    <div class="admission-application-view student-block">
        <?= \yii\bootstrap\Tabs::widget([
            'options'           => [
                'class' => 'card-header'
            ],
            'tabContentOptions' => [
                'class' => 'card-body'
            ],
            'items'             => [
                [
                    'label'   => 'Персональные данные',
                    'content' => $this->render('_person', compact('model')),
                    'active'  => true
                ],
                [
                    'label'   => 'Контактные данные',
                    'content' => $this->render('_contacts', compact('model')),
                ],
                [
                    'label'   => 'Льготы',
                    'content' => $this->render('_social_statuses', compact('model')),
                ],
            ]
        ])
        ?>
    </div>

<?php
Modal::begin([
    'id'     => 'admission-application-receipt-modal',
    'header' => '<h4 class="modal-title">' . Yii::t('app', 'Расписка') . '</h4>',
]);

$form = ActiveForm::begin([
    'action'      => ['/admission-application/receipt', 'id' => $model->id],
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label'   => 'col-sm-8',
            'wrapper' => 'col-sm-4'
        ],
        'labelOptions'         => [
            'style' => 'text-align: left;',
        ],
    ],
    'layout'      => 'horizontal',
    'options'     => [
        'target' => '_blank'
    ],
]);

echo $form->field($receiptForm, 'applications_count')->textInput(['type' => 'number', 'min' => 0]);
echo $form->field($receiptForm, 'school_certificates_count')->textInput(['type' => 'number', 'min' => 0]);
echo $form->field($receiptForm, 'medical_certificates_count')->textInput(['type' => 'number', 'min' => 0]);
echo $form->field($receiptForm, 'medical_commission_opinions_count')->textInput(['type' => 'number', 'min' => 0]);
echo $form->field($receiptForm, 'photos_count')->textInput(['type' => 'number', 'min' => 0]);
echo $form->field($receiptForm, 'ent_certificates_count')->textInput(['type' => 'number', 'min' => 0]);
?>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary pull-right']); ?>
        </div>
    </div>
<?php
ActiveForm::end();
Modal::end();
?>