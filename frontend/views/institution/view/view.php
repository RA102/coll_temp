<?php

use common\helpers\InstitutionHelper;
use common\models\organization\Institution;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Institution */

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
                'name',
                [
                    'attribute' => 'city_id',
                    'value' => function(Institution $model) {
                        return $model->city->name ?? null;
                    }
                ],
                [
                    'attribute' => 'street_id',
                    'value' => function(Institution $model) {
                        return $model->street->caption_current ?? null;
                    }
                ],
                'house_number',
                'foundation_year',
                'phone',
                'fax',
                'email',
                'bin',
                'website',
                [
                    'attribute' => 'educational_form_id',
                    'value' => function(Institution $model) {
                        return $model->educationalForm->name ?? null;
                    }
                ],
            ],
        ]) ?>
<?php $this->endBlock() ?>

<?= $this->render('_view_layout', ['model' => $model]) ?>
