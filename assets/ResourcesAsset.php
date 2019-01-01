<?php

namespace app\assets;

/**
 * Application Asset File.
 */
class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        'css/style.css'
    ];

    public $js = [
    ];
    
    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
        ]
    ];


    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\TempAsset',
    ];
}
