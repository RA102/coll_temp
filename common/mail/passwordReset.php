<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $token string */

$host = Yii::$app->params['college_host'];
$resetLink = $host . Yii::$app->urlManager->createUrl(['site/reset-password', 'token' => $token]);
?>
<div class="password-reset">
    <p>Пройдите по ссылке для изменения пароля:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
