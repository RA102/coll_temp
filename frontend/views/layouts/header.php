<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <nav class="navbar navbar-static-top" role="navigation">
        <div class="pull-left" style="display: flex;align-items: center;">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <a href="/" class=" navbar-brand">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <span class="navbar-text px-3 navbar-title hidden-xs">
                Бiлiмал. Электронды колледж
                <span><?=Yii::$app->user->identity->institution->name?></span>
            </span>
        </div>

        <div class="navbar-custom-menu" style="display: flex;align-items: center;height: 68px;">

            <ul class="nav navbar-nav">

                <!-- <li class="languages">
                    <ul class="languages__list">
                        <li class="languages__item">
                            <a href="#" target="_self" class="languages__link languages__link">Рус</a>
                        </li>
                        <li class="languages__item">
                            <a href="#" target="_self" class="languages__link languages__link--active">Каз</a>
                        </li>
                    </ul>
                </li> -->

                <li>
                    <a title="Инструкция пользователя" rel="noopener"
                       href="/files/instruction_bilimal.pdf?1"
                       target="_blank" class="nav-help">
                        <i class="fa fa-question-circle"></i>
                    </a>
                </li>

                <!-- Messages: style can be found in dropdown.less-->


                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle navbar-username" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->getFullName()?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    Yii::t('app', 'Profile'),
                                    ['/employee/view', 'id' => Yii::$app->user->id],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
<!--                                <a href="#" class="btn btn-default btn-flat">--><?//=Yii::t('app', 'Profile')?><!--</a>-->
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('app', 'Sign out'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
