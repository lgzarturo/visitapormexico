<?php

declare(strict_types=1);

namespace App\Core;
use App\Exceptions\StatusCode;

/**
 * Framework class.
 *
 * Represents a web page, is the base class for all web pages.
 *
 * @package App
 *
 */
class Application
{
    /**
     * The framework instance used by the web page.
     *
     * @var Framework
     *
     */
    private Framework $framework;

    /**
     * The title of the web page.
     *
     * @var string
     *
     */
    private string $title;

    /**
     * The description of the web page.
     *
     * @var string
     *
     */
    private string $description;

    private Security $security;
    private string $port;
    private string $host;
    private string $protocol;
    private string $url;
    private array $uri = [];


    /**
     * Creates a new instance of the WebPage class.
     *
     * Constants of the assets URLs are defined here.
     *
     * @param string $title The title of the web page.
     * @param string $description The description of the web page.
     *
     */
    private function __construct(string $title, string $description)
    {
        $ignorePorts = ['80', '443'];
        $port = $_SERVER['SERVER_PORT'] ?? '80';
        $this->port = in_array($port, $ignorePorts) ? '' : ':' . $port;
        $this->host = $_SERVER['HTTP_HOST'];
        $this->protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $this->url = $this->protocol . '://' . $this->host . $this->port;
        define('BASE_URL', $this->url);
        define('ASSETS_URL', BASE_URL . '/assets');
        define('CSS_URL', ASSETS_URL . '/css');
        define('JS_URL', ASSETS_URL . '/js');
        define('IMG_URL', ASSETS_URL . '/img');
        $this->framework = Framework::init(
            'VisitaPorMexico',
            '1.0.0',
            'Arturo López',
            'America/Cancun',
            'es',
        );
        $this->security = Security::init();
        $this->framework->info('Webapp started');
        session_start();
        $this->autoload();
        $this->title = $title;
        $this->description = $description;
        $this->filterUri();
        $this->dispatch();
    }

    /**
     * Initializes a new instance of the WebPage class.
     *
     * @param string $title The title of the web page.
     * @param string $description The description of the web page.
     *
     * @return self
     *
     */
    final public static function init(string $title, string $description): self
    {
        return new self($title, $description);
    }

    /**
     * Gets the framework instance used by the web page.
     *
     * @return Framework
     *
     */
    final public function getFramework(): Framework
    {
        return $this->framework;
    }

    /**
     * Gets the title of the web page.
     *
     * @return string
     *
     */
    final public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Gets the description of the web page.
     *
     * @return string
     *
     */
    final public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Gets the security instance used by the web page.
     *
     * @return Security
     *
     */
    final public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * Autoloads the necessary files for the application to run.
     *
     * @return void
     *
     */
    private function autoload(): void
    {
        require_once HELPERS_PATH . DS . 'CoreFunctions.php';
    }

    /**
     * Filters the URI from the $_GET superglobal variable.
     *
     * If the 'uri' key is set in the $_GET superglobal variable, this method will filter it by:
     * - Removing trailing slashes
     * - Sanitizing the URI using FILTER_SANITIZE_URL filter
     * - Converting the URI to lowercase
     * - Stripping HTML tags from each URI segment
     * - Trimming each URI segment
     * - Removing empty URI segments
     *
     * The filtered URI is then stored in the $uri property of the Application class.
     *
     * @return void
     *
     */
    private function filterUri(): void
    {
        if (isset($_GET['uri'])) {
            $uri = $_GET['uri'];
            $uri = rtrim($uri, '/');
            $uri = filter_var($uri, FILTER_SANITIZE_URL);
            $uri = explode('/', strtolower($uri));
            $uri = array_map('strip_tags', $uri);
            $uri = array_map('trim', $uri);
            $uri = array_filter($uri);
            $this->uri = $uri;
            return;
        }
    }

    /**
     * Dispatches the request to the appropriate controller and action.
     *
     * @throws \Exception If an error occurs while loading the controller or its parameters.
     *
     * @return void
     *
     */
    private function dispatch() : void
    {
        $controller = $this->uri[0] ?? 'home';
        $action = $this->uri[1] ?? 'index';
        $params = [];

        try {
            $controller = $this->loadAction($controller, $action);
            $params = $this->loadParams();
        } catch (\Exception $e) {
            $this->framework->error(sprintf(
                'Error %d: %s',
                $e->getCode(),
                $e->getMessage()
            ));
            $action = StatusCode::getActionFromStatusCode($e->getCode());
            $controller = $this->loadAction('error', $action);
        }

        $controller->$action(...$params);
    }

    /**
     * Loads the specified action from the given controller.
     *
     * @param string $controller The name of the controller to load.
     * @param string $action The name of the action to load.
     *
     * @throws \Exception If the controller file or class is not found, or if the action method is not found.
     *
     * @return mixed The loaded controller object.
     *
     */
    private function loadAction(string $controller, string $action) : mixed {
        $controller = ucfirst($controller);
        $controllerName = $controller . 'Controller';
        $controller = CONTROLLERS_PATH . DS . $controllerName . '.php';
        if (!file_exists($controller)) {
            throw new \Exception('Controller file not found', StatusCode::HTTP_NOT_IMPLEMENTED);
        }
        $controllerClass = CONTROLLERS_NAMESPACE . $controllerName;
        if (!class_exists($controllerClass)) {
            throw new \Exception('Controller class not found', StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            throw new \Exception('Action method not found', StatusCode::HTTP_NOT_FOUND);
        }
        return $controller;
    }

    /**
     * Load parameters from the URI.
     *
     * @throws \Exception If there are too many parameters.
     *
     * @return array An array of parameters.
     *
     */
    private function loadParams() : array {
        $params = array_slice($this->uri, 2);
        if (empty($params)) {
            $params = [];
        }
        if (count($params) > 200) {
            throw new \Exception('Too many parameters', StatusCode::HTTP_REQUEST_URI_TOO_LONG);
        }
        return $params;
    }
}
