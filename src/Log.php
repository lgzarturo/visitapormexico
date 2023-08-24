<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

/**
 * This class will handle all the logging
 * @package App
 */
class Log
{
    private string $logFile;
    private Logger $log;
    private Level $level;

    private function __construct(Config $config, string $name)
    {
        $this->logFile = $config->getLogFile();
        $this->level = $config->getLogLevel();
        $dateFormat = "Y n j, g:i a";
        $output = "%level_name% \t [%datetime%] \t %message% - %context% - %extra%\n";
        $formatter = new LineFormatter($output, $dateFormat);
        $this->log = new Logger($name);
        $stream = new StreamHandler($this->logFile, $this->level);
        $stream->setFormatter($formatter);
        $this->log->pushHandler($stream);
    }

    final public function error(string $message): void
    {
        $this->log->error($message);
    }

    final public function info(string $message): void
    {
        $this->log->info($message);
    }

    final public function debug(string $message): void
    {
        $this->log->debug($message);
    }

    final public static function init(Config $config, string $name): self
    {
        return new self($config, $name);
    }
}
