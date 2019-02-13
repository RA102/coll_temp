<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/_fonts.css',
        'css/site.css',
        'css/modified_lte.css',
        'css/_buttons.css',
        'css/_grid.css',
        'https://use.fontawesome.com/releases/v5.7.1/css/all.css',
        'css/_card.css',
        'css/app.css',
        'css/_students.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
