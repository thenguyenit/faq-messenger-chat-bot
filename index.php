<?php
//file_put_contents('var/log/app.log', print_r($_REQUEST, true) . "\n", FILE_APPEND);
/**
 * Register The Auto Loader
 */


require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/vendor/autoload.php';

//echo \App\Model\Message\KindOfIssue::class;
//$a = new \App\Model\Message\KindOfIssue();
var_dump(class_exists($className = '\App\Model\Message\\' . 'KindOfIssue'));

die;
define('ROOT_PATH', __DIR__);

/**
 * Run The Application
 */

$dotEnv = new \Dotenv\Dotenv(__DIR__);
$dotEnv->load();

$app = new \App\Controller\IndexController();
$app->exec();