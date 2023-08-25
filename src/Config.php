<?php

declare(strict_types=1);

namespace App;

use Monolog\Level;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define DS as the directory separator
const DS = DIRECTORY_SEPARATOR;

// Define BASE_PATH as the root directory of the project
define("App\BASE_PATH", dirname(__DIR__));

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
 */
class Config
{
    private bool $errorReporting;
    private bool $displayErrors;
    private bool $logErrors;
    private string $logFile;
    private Level $logLevel;

    private function __construct()
    {
        $this->errorReporting = true;
        $this->displayErrors = true;
        $this->logErrors = true;
        $this->logFile = BASE_PATH . DS . 'logs' . DS . 'visitapormexico.log';
        $this->logLevel = Level::Debug;
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

    /**
     * Initializes the Config class and calls the config method.
     *
     * @return self Returns an instance of the Config class.
     */
    final public static function init(): self
    {
        $self = new self();
        $self->config();
        return $self;
    }
}
