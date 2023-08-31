<?php

declare(strict_types=1);

namespace App\Core;

use Monolog\Level;

// Define DS as the directory separator
const DS = DIRECTORY_SEPARATOR;

/**
 * Config class.
 *
 * This class will load the configuration for the application
 *
 * Constants of the application are defined here.
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
        $this->basePath = dirname(__DIR__, 2);
        $this->errorReporting = true;
        $this->displayErrors = true;
        $this->logErrors = true;
        $this->logFile = $this->basePath . DS . 'logs' . DS . 'visitapormexico.log';
        $this->logLevel = Level::Debug;
        $this->isProduction = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
        $this->timezone = $timezone;
        $this->language = $language;
        $this->autoloadFile = $this->basePath . DS . 'vendor' . DS . 'autoload.php';
        if (!file_exists($this->autoloadFile)) {
            throw new \Exception('Autoload file not found');
        }
        require_once $this->autoloadFile;
        date_default_timezone_set($this->timezone);
        define('DS', DS);
        define('BASE_PATH', $this->basePath);
        define('LOGS_PATH', BASE_PATH . DS . 'logs');
        define('VENDOR_PATH', BASE_PATH . DS . 'vendor');
        define('APP_PATH', BASE_PATH . DS . 'src');
        define('CONTROLLERS_PATH', APP_PATH . DS . 'Controllers');
        define('CONTROLLERS_NAMESPACE', 'App\\Controllers\\');
        define('CORE_PATH', APP_PATH . DS . 'Core');
        define('CORE_NAMESPACE', 'App\\Core\\');
        define('CRUD_PATH', APP_PATH . DS . 'Crud');
        define('CRUD_NAMESPACE', 'App\\Crud\\');
        define('EXAMPLES_PATH', APP_PATH . DS . 'Examples');
        define('EXAMPLES_NAMESPACE', 'App\\Examples\\');
        define('EXCEPTIONS_PATH', APP_PATH . DS . 'Exceptions');
        define('EXCEPTIONS_NAMESPACE', 'App\\Exceptions\\');
        define('HELPERS_PATH', APP_PATH . DS . 'Helpers');
        define('HELPERS_NAMESPACE', 'App\\Helpers\\');
        define('HOOKS_PATH', APP_PATH . DS . 'Hooks');
        define('HOOKS_NAMESPACE', 'App\\Hooks\\');
        define('MODELS_PATH', APP_PATH . DS . 'Models');
        define('MODELS_NAMESPACE', 'App\\Models\\');
        define('ROUTES_PATH', APP_PATH . DS . 'Routes');
        define('ROUTES_NAMESPACE', 'App\\Routes\\');
        define('SERVICES_PATH', APP_PATH . DS . 'Services');
        define('SERVICES_NAMESPACE', 'App\\Services\\');
        define('TEMPLATES_PATH', APP_PATH . DS . 'Templates');
        define('TEMPLATES_NAMESPACE', 'App\\Templates\\');
        define('INCLUDES_PATH', TEMPLATES_PATH . DS . 'Includes');
        define('INCLUDES_NAMESPACE', 'App\\Templates\\Includes');
        define('LAYOUTS_PATH', TEMPLATES_PATH . DS . 'Layouts');
        define('LAYOUTS_NAMESPACE', 'App\\Templates\\Layouts');
        define('PAGES_PATH', TEMPLATES_PATH . DS . 'Pages');
        define('PAGES_NAMESPACE', 'App\\Templates\\Pages');
        define('VIEWS_PATH', TEMPLATES_PATH . DS . 'Views');
        define('VIEWS_NAMESPACE', 'App\\Templates\\Views');
        define('WIDGETS_PATH', TEMPLATES_PATH . DS . 'Widgets');
        define('WIDGETS_NAMESPACE', 'App\\Templates\\Widgets');
        define('TESTS_PATH', APP_PATH . DS . 'tests');
        define('TESTS_NAMESPACE', 'App\\tests\\');
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
