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
        '02-grid.css',
        'css/site.css',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/jqBootstrapValidation.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}