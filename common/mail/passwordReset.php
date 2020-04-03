<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $token string */

$host = Yii::$app->params['college_host'];
$resetLink = $host . Yii::$app->urlManager->createUrl(['site/reset-password', 'token' => $token]);
?>
<div class="password-reset">
    <p>Вы получили это письмо, потому что запросили смену пароля. Пройдите по временной ссылке для изменения пароля:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    
    <p><h5>Обращаем Ваше внимание, что ссылка одноразовая, Вы не сможете ее активировать повторно!</h5></p>
    <p>Если указанная ссылка не работает, вы можете запросить новую на <a href="https://college.bilimal.kz/site/request-password-reset">форме восстановления.</a></p>
</div>
