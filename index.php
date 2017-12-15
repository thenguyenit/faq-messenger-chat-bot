<?php
file_put_contents('var/log/app.log', print_r($_REQUEST, true) . "\n", FILE_APPEND);
/**
 * Register The Auto Loader
 */

define('ROOT_PATH', __DIR__);

require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/vendor/autoload.php';

/**
 * Run The Application
 */

$dotEnv = new \Dotenv\Dotenv(__DIR__);
$dotEnv->load();

try {
    $app = new \App\Controller\IndexController();
    $app->exec();
} catch (\Exception $exception) {
    $logger = new \App\Helper\Logger();
    $logger->debug($exception);
}
