<?php

namespace App\Helper;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

class Logger {

    public function __construct($name = 'app')
    {
        $this->logger = new MonoLogger($name);
        $this->logger->pushHandler(new StreamHandler(LOG_PATH . '/' . $name . '.log', MonoLogger::WARNING));
    }

    public function info($message, array $context = array())
    {
        return $this->logger->info($message, $context);
    }
    
    public function warning($message, array $context = array())
    {
        return $this->logger->warning($message, $context);
    }
}