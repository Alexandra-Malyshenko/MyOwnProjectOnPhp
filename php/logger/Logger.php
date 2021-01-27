<?php

namespace php\logger;

class Logger implements LoggerInterface
{

    public function emergency($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    public function error($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }


    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }


    public function notice($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }


    public function info($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }


    public function debug($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }


    public function log($level, $message, array $context = array())
    {
//        $context = implode(',' , $context);
        echo '<pre>' . $level . "\n" . $message . "\n" . '</pre>';
    }

    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }
}