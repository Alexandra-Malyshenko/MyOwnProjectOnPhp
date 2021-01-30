<?php

namespace App\tools\logger;

class Logger implements LoggerInterface
{
    public $name;
    public $id;
    public function __construct(string $name = '' )
    {
        $this->name = $name;
    }

    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }


    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }


    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }


    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }


    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        if ($this->name == '') {
            $fl = fopen(__DIR__ . '/../', 'a+');
            $date = date('D-M-Y h:m:s');
            $context = implode(',', $context);
            $message = 'Date: ' . $date . "\n" . 'Message: ' . $message . $context . "\n". '########################' . "\n";
            fwrite($fl, $message);
            fclose($fl);
        } elseif (!empty($this->name)) {
            $fl = fopen(__DIR__ . '/../../storage/log/' . $this->name . ".log", 'a+');
            $date = date('D-M-Y h:m:s');
            $context = implode(',', $context);
            $message = 'Date: ' . $date . "\n" . 'Message: ' . $message . $context . "\n". '########################' . "\n";
            fwrite($fl, $message);
            fclose($fl);
        }
    }
}