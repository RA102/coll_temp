<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card p-4">
    <div class="card-body">
        <h1>Авторизация</h1>
        <p class="text-muted">Вход в ваш аккаунт</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')
            ->textInput(['placeholder' => 'E-mail'])
            ->label(false) ?>

        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => Yii::t('app', 'Password')])
            ->label(false)
        ?>

        <div class="row">
            <div class="col-md-6">
                <?= Html::submitButton(Yii::t('app', 'Login'),
                    ['class' => 'btn btn-primary px-4', 'name' => 'login-button'])
                ?>
            </div>
            <div class="col-md-6">
                <?= Html::a(Yii::t('app', 'Forgot password?'), ['site/request-password-reset'],
                    ['class' => 'pull-right btn px-0']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="card text-white bg-primary py-5 d-md-down-none" style="width: 44%">
    <div class="card-body text-center">
        <div>
            <h2>Регистрация</h2>
            <p>Если вы образовательное учреждение,
                то можете оставить заявку на подключение к системе.</p>
            <a href="/signup" class="btn active mt-3 btn-primary" target="_self">
                Подключиться!
            </a>
        </div>
    </div>
</div>
