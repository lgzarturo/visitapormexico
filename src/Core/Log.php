<?php

declare(strict_types=1);

namespace App\Core;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Log class.
 *
 * The Log class provides a simple interface for logging messages to a file.
 *
 * @package App
 *
 */
class Log
{
    /**
     * The path to the log file.
     *
     * @var string
     *
     */
    private string $logFile;

    /**
     * The logger instance.
     *
     * @var Logger
     *
     */
    private Logger $log;

    /**
     * The logging level.
     *
     * @var Level
     */
    private Level $level;

    /**
     * Creates a new Log instance.
     *
     * @param Config $config The configuration object.
     * @param string $name The name of the logger.
     *
     */
    private function __construct(Config $config, string $name)
    {
        $this->logFile = $config->getLogFile();
        $this->level = $config->getLogLevel();
        $dateFormat = 'Y n j, g:i a';
        $output = "%level_name% \t [%datetime%] \t %message% - %context% - %extra%\n";
        $formatter = new LineFormatter($output, $dateFormat);
        $this->log = new Logger($name);
        $stream = new StreamHandler($this->logFile, $this->level);
        $stream->setFormatter($formatter);
        $this->log->pushHandler($stream);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The message to log.
     *
     * @return void
     *
     */
    final public function error(string $message): void
    {
        $this->log->error($message);
    }

    /**
     * Logs an info message.
     *
     * @param string $message The message to log.
     *
     * @return void
     *
     */
    final public function info(string $message): void
    {
        $this->log->info($message);
    }

    /**
     * Logs a debug message.
     *
     * @param string $message The message to log.
     *
     * @return void
     *
     */
    final public function debug(string $message): void
    {
        $this->log->debug($message);
    }

    /**
     * Initializes a new Log instance.
     *
     * @param Config $config The configuration object.
     * @param string $name The name of the logger.
     *
     * @return self
     *
     */
    final public static function init(Config $config, string $name): self
    {
        return new self($config, $name);
    }
}
