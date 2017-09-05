<?php

namespace sirgalas\menu;
use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath =__DIR__ . '/assets';

    public $css = [
        'css/style.css',
    ];
    public $js=[
        'js/script.js',
        'js/nav.js',
        'js/dropzone.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset',
    ];
}
