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
        'css/animate.css',
        'lightbox/css/lightbox.min.css',
        'scss/base.scss',
        'scss/site-header.scss',
        'scss/site-languages.scss',
        'scss/site-logo.scss',
        'scss/site-front-photo.scss',
    ];

    public $js = [
        'js/header.js',
        'lightbox/js/lightbox.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
