<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/contact_me.js',
        'js/jqBootstrapValidation.js',
        'js/jquery.min.js',
        'js/jquery.stellar.min.js',
        'js/main.js',
        'js/popupCategoria.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
