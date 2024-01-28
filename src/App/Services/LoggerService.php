<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Contracts\LoggerInterface;

class LoggerService implements LoggerInterface
{
    //TODO should be in constructor
    private string $logFilePath;
    private string $fileName;
    public function __construct(

    ){
        $this->logFilePath = $_SERVER['DOCUMENT_ROOT'].'/logs/';
        $this->fileName = 'info-logs.txt';
    }

    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }

    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }

    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }

    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }

    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }

    public function info($message, array $context = array()): void
    {
        $this->log('info', $message, $context);
    }

    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }

    public function log($level, $message, array $context = array()): void
    {
        // Vytvori záznam
        $logEntry = sprintf("[%s] %s: %s\n", $level, $message, json_encode($context));

        // Přidání záznamu do souboru
        if(!is_dir($this->logFilePath)){
            mkdir($this->logFilePath, 0777, true);
            touch($this->logFilePath . $this->fileName);
        }
        file_put_contents($this->logFilePath.$this->fileName, $logEntry, FILE_APPEND);
    }
}