<?php


namespace app\assets;

use yii\web\AssetBundle;


//class LoginAsset extends AssetBundle
//{
//    public $sourcePath = '@bower/login/';
//    public $css = [
//        'css/style.css',
//    ];
//    public $js = [
//        'js/jquery-2.1.4.min.js',
//    ];
//    public $depends = [
////        'yii\web\YiiAsset',
////        'yii\bootstrap\BootstrapAsset',
//    ];
//}

class LoginAsset extends AssetBundle
{
    public $sourcePath = '@bower/login2/';
    public $css = [
        'css/animate-custom.css',
        'css/style.css',
    ];
//    public $js = [
//        'js/jquery-2.1.4.min.js',
//    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}