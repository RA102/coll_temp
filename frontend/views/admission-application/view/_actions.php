<?php

use yii\helpers\Html;

/* @var $model common\models\educational_process\AdmissionApplication */

?>

<p>
    <?= Html::a(Yii::t('app', 'Сменить статус'), ['change-status', 'id' => $model->id],
        ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>
