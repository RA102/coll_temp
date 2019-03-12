<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $form frontend\models\forms\PersonContactsForm */

?>

<?php $this->beginBlock('view-content') ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => $form->getAttributeLabel('contact_phone_home'),
                'value' => $form->contact_phone_home,
            ],
            [
                'label' => $form->getAttributeLabel('contact_phone_mobile'),
                'value' => $form->contact_phone_mobile,
            ],
            [
                'label' => 'Гражданство',
                'value' => null
            ],
            [
                'label' => $form->getAttributeLabel('location_registration'),
                'value' => function ($model) use ($form) {
                    $result = [];
                    if (($id = $form->registration_country_id) !== null) {
                        $result[] = \common\models\Country::findOne($id)->caption_current;
                    }
                    if (($ids = $form->registration_city_ids)) {
                        $result[] = \common\models\CountryUnit::findOne(end($ids))->caption_current;
                    }
                    if (($id = $form->registration_street_id) !== null) {
                        $result[] = \common\models\Street::findOne($id)->caption_current;
                    }

                    return implode(', ', $result);
                },
            ],
            [
                'label' => $form->getAttributeLabel('location_residence'),
                'value' => function ($model) use ($form) {
                    $result = [];
                    if (($id = $form->residence_country_id) !== null) {
                        $result[] = \common\models\Country::findOne($id)->caption_current;
                    }
                    if (($ids = $form->residence_city_ids)) {
                        $result[] = \common\models\CountryUnit::findOne(end($ids))->caption_current;
                    }
                    if (($id = $form->residence_street_id) !== null) {
                        $result[] = \common\models\Street::findOne($id)->caption_current;
                    }

                    return implode(', ', $result);
                },
            ],
            [
                'label' => 'Место рождения',
                'value' => null
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update-contacts', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>