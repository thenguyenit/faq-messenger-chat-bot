<?php

define('LOG_PATH', ROOT_PATH . '/var/log');

if (isset($_SERVER['REQUEST_SCHEME']) && isset($_SERVER['HTTP_HOST'])) {
    define('STATIC_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/pub/static');
    define('IMG_STATIC_URL', STATIC_URL . '/image');
}
