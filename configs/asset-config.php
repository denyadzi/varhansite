<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
// Yii::setAlias('@webroot', __DIR__ . '/../web');
// Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'uglifyjs {from} --output {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'uglifycss {from} --output {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    'bundles' => [
        'app\assets\ResourcesAsset',
        'app\assets\blocks\ContentAsset',
        'app\assets\blocks\NavigationAsset',
        'app\assets\blocks\StaticBackgroundAsset',
        'app\assets\blocks\MediaAsset',
        'app\assets\blocks\FbAlbumsAsset',
        // 'yii\web\YiiAsset',
        // 'yii\web\JqueryAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'js/all-{hash}.js',
            'css' => 'css/all-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'fileMode' => 0664,
        'dirMode' => 0775,
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'bundles' => [
            'yii\web\JqueryAsset' => false,
        ],
        'converter' => [
            'class' => 'yii\web\AssetConverter',
            'commands' => [
                'scss' => ['css', 'node-sass {from} > {to}'],
            ],
        ],
    ],
];
