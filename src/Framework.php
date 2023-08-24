<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * This class is the main class of the framework
 * @package App
 */
class Framework
{
    private string $name;
    private string $version;
    private string $author;
    private Config $config;
    private Log $log;

    private function __construct(string $name, string $version, string $author)
    {
        $this->name = $name;
        $this->version = $version;
        $this->author = $author;
    }

    private function start(): void
    {
        $this->config = Config::init();
        $this->log = Log::init($this->config, $this->name);
        $this->log->info("{$this->name} {$this->version} by {$this->author}");
    }

    final public static function init(string $name, string $version, string $author): self
    {
        $self = new self($name, $version, $author);
        $self->start();
        return $self;
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

    final public function getVersion(): string
    {
        return $this->version;
    }

    final public function getCopyRight(): string
    {
        $year = date('Y');
        return "{$this->name} {$year} &copy {$this->version} by {$this->author}";
    }
}
