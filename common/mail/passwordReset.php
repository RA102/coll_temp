<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $token string */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $token]);
?>
<div class="password-reset">
    <p>Пройдите по ссылке для изменения пароля:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
