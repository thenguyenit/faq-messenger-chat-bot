<?php

namespace App\Helper;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

class Logger {

    protected $logger;

    public function __construct($name = 'app')
    {
        $this->logger = new MonoLogger($name);
        $this->logger->pushHandler(new StreamHandler(LOG_PATH . '/' . $name . '.log'));
    }

    public function debug($message, array $context = array())
    {
        return $this->logger->debug($message, $context);
    }
}