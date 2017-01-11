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
        'plugins/owl-carousel/owl.carousel.css',
        'plugins/owl-carousel/owl.theme.css',
        'plugins/owl-carousel/owl.transitions.css',
        "plugins/dropzone.css",
        "plugins/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css",
        "plugins/font-awesome-4.6.3/css/font-awesome.min.css",
        'css/style.css?17',
    ];
    public $js = [
        "plugins/owl-carousel/owl.carousel.min.js",
        "plugins/dropzone.js",
        "plugins/jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.min.js",
        "js/app.js?17",
        "js/menu.js",
        "js/advert_right.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
