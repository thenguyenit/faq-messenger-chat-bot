<?php

define('LOG_PATH', ROOT_PATH . '/var/log');

defined('STATIC_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/pub/static');
defined('IMG_STATIC_URL', STATIC_URL . '/icon');
