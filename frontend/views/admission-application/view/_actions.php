<?php

use yii\helpers\Html;

/* @var $model common\models\reception\AdmissionApplication */

?>

<p>
    <?php 
        if ($model->online == null || $model->online < 1){
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }

    ?>
</p>
