<?php

/**
 * This config should be used on preproduction enviroment.
 * The preproduction enviroment will be used to show the website to the customer and prepare it for prod deployment.
 */

/*
 * Enable or disable the debugging, if those values are deleted YII_DEBUG is false and YII_ENV is prod.
 * The YII_ENV value will also be used to load assets based on enviroment (see assets/ResourcesAsset.php)
 */
define ('YII_ENV', 'prep');
define ('YII_DEBUG', false);

$config = require ('env-common.php');

return \yii\helpers\ArrayHelper::merge($config, require('env-local-db.php'));
