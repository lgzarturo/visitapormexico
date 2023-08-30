<?php

declare(strict_types=1);

namespace App\Core;

use Monolog\Level;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

// Define DS as the directory separator
const DS = DIRECTORY_SEPARATOR;

/**
 * Config class.
 *
 * This class will load the configuration for the application
 *
 * This class represents the configuration settings for the application.
 * It sets the error reporting, display errors, log errors, log file, and log level.
 * It also provides methods to get the log file and log level, and to initialize the configuration.
 *
 * @package App
 *
 */
class Config
{
    private bool $errorReporting;
    private bool $displayErrors;
    private bool $logErrors;
    private string $logFile;
    private Level $logLevel;
    private bool $isProduction;
    private array $environments = [
        'dev' => 'development',
        'prod' => 'production'
    ];
    private string $timezone;
    private string $language;
    private string $basePath;
    private string $autoloadFile;

    /**
     * Creates a new instance of the Config class.
     *
     * @param string $timezone The timezone for the application.
     * @param string $language The language for the application.
     *
     */
    private function __construct(string $timezone, string $language)
    {
        $this->basePath = dirname(__DIR__) . DS . '../';
        $this->errorReporting = true;
        $this->displayErrors = true;
        $this->logErrors = true;
        $this->logFile = $this->basePath . 'logs' . DS . 'visitapormexico.log';
        $this->logLevel = Level::Debug;
        $this->isProduction = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
        $this->timezone = $timezone;
        $this->language = $language;
        $this->autoloadFile = $this->basePath . 'vendor' . DS . 'autoload.php';
        // Check if the autoload file exists before loading it
        if (!file_exists($this->autoloadFile)) {
            throw new \Exception('Autoload file not found');
        }
    }

    final public function getLogFile(): string
    {
        return $this->logFile;
    }

    final public function getLogLevel(): Level
    {
        return $this->logLevel;
    }

    /**
     * Sets the configuration for error reporting and logging.
     *
     * @return void
     *
     */
    final public function config(): void
    {
        // Show all errors
        error_reporting($this->errorReporting ? 1 : 0);

        // Show errors in browser
        ini_set('display_errors', $this->displayErrors ? 'On' : 'Off');

        // Log errors
        ini_set('log_errors', $this->logErrors ? 'On' : 'Off');

        // Save log in file visitapormexico.err.log
        ini_set('error_log', $this->logFile);
    }

    final public function getEnvironment(): string
    {
        return $this->isProduction ? $this->environments['prod'] : $this->environments['dev'];
    }

    final public function getTimezone(): string
    {
        return $this->timezone;
    }

    final public function getLanguage(): string
    {
        return $this->language;
    }

    final public function getBasePath(): string
    {
        return $this->basePath;
    }

    final public function getAutoloadFile(): string
    {
        return $this->autoloadFile;
    }

    /**
     * Initializes the Config class and calls the config method.
     *
     * @param string $timezone The timezone for the application.
     * @param string $language The language for the application.
     *
     * @return self Returns an instance of the Config class.
     *
     */
    final public static function init(string $timezone, string $language): self
    {
        $self = new self($timezone, $language);
        $self->config();
        return $self;
    }
}
