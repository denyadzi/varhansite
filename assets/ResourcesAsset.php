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
    ];

    public $js = [
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
