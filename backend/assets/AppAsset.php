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
        '02-grid.css',
    ];

    public $js = [
        'js/popupCategoria.js',
//        'js/checkUpdate.js',
//        'js/contact_me.js',
        'js/jqBootstrapValidation.js',
//        'js/bootstrap.min.js',
//        'js/jquery.min.js',
//        'js/jquery.stellar.min.js',
//        'js/main.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
