<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Framework class.
 *
 * The Framework class represents a basic framework for building PHP applications.
 *
 * @package App
 *
 */
class Framework
{
    /**
     * The name of the framework.
     *
     * @var string
     *
     */
    private string $name;

    /**
     * The version of the framework.
     *
     * @var string
     *
     */
    private string $version;

    /**
     * The author of the framework.
     *
     * @var string
     *
     */
    private string $author;

    /**
     * The configuration object for the framework.
     *
     * @var Config
     *
     */
    private Config $config;

    /**
     * The log object for the framework.
     *
     * @var Log
     *
     */
    private Log $log;

    /**
     * Constructs a new Framework object with the given name, version, and author.
     *
     * @param string $name The name of the framework.
     * @param string $version The version of the framework.
     * @param string $author The author of the framework.
     *
     */
    private function __construct(string $name, string $version, string $author)
    {
        $this->name = $name;
        $this->version = $version;
        $this->author = $author;
    }

    /**
     * Initializes the configuration and log objects for the framework.
     *
     * @return void
     *
     */
    private function start(): void
    {
        $this->config = Config::init();
        $this->log = Log::init($this->config, $this->name);
        $this->log->info("{$this->name} {$this->version} by {$this->author}");
    }

    /**
     * Initializes a new Framework object with the given name, version, and author.
     *
     * @param string $name The name of the framework.
     * @param string $version The version of the framework.
     * @param string $author The author of the framework.
     *
     * @return self
     *
     */
    final public static function init(string $name, string $version, string $author): self
    {
        $self = new self($name, $version, $author);
        $self->start();
        return $self;
    }

    /**
     * Logs an error message to the log object.
     *
     * @param string $message The error message to log.
     *
     * @return void
     *
     */
    final public function error(string $message): void
    {
        $this->log->error($message);
    }

    /**
     * Logs an info message to the log object.
     *
     * @param string $message The info message to log.
     *
     * @return void
     *
     */
    final public function info(string $message): void
    {
        $this->log->info($message);
    }

    /**
     * Logs a debug message to the log object.
     *
     * @param string $message The debug message to log.
     *
     * @return void
     *
     */
    final public function debug(string $message): void
    {
        $this->log->debug($message);
    }

    /**
     * Returns the version of the framework.
     *
     * @return string
     *
     */
    final public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Returns the copyright notice for the framework.
     *
     * @return string
     *
     */
    final public function getCopyRight(): string
    {
        $year = date('Y');
        return "{$this->name} {$year} &copy {$this->version} by {$this->author}";
    }
}
