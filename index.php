<?php

/**
 * Register The Auto Loader
 */

define('ROOT_PATH', __DIR__);

require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/vendor/autoload.php';

/**
 * Run The Application
 */
$app = new \App\Controller\IndexController();
$app->exec();