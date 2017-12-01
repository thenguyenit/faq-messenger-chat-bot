<?php

/**
 * Register The Auto Loader
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Run The Application
 */
$app = new \App\Controller\IndexController();
$app->exec();