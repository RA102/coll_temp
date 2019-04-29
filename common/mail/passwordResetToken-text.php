<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$host = Yii::$app->params['college_host'];
$resetLink = $host . Yii::$app->urlManager->createUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
