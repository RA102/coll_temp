<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><i class="fa fa-tag"></i> <?= Html::encode($this->title) ?></h1>
        <div class="box-tools pull-right">
            <?= $this->blocks["tools"] ?? ''; ?>
        </div><!-- /.box-tools -->
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">

                <?= $this->blocks["content"] ?>

            </div>
        </div>
    </div>
</div>
