<?php

namespace app\assets;

/**
 * Application Asset File.
 */
class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        'css/normalize.css',
        'css/skeleton.css',
        'css/header.css',
    ];

    public $js = [
        'js/header.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
