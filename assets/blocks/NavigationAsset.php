<?php

namespace app\assets\blocks;

class NavigationAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources-block/navigation';
    public $css = [
        'scss/style.scss',
    ];
    public $js = [
        'js/jquery.sticky.js',
        'js/tinynav.js',
        'js/block.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
