<?php

/* @var $this yii\web\View */
/* @var $model common\models\educational_process\AdmissionApplication */

$this->title = Yii::t('app', 'Заявление') . " №{$model->id}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
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
