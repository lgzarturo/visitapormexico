<?php

declare(strict_types=1);

namespace App\Core;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

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

    /**
     * Creates a new instance of the WebPage class.
     *
     * @param string $title The title of the web page.
     * @param string $description The description of the web page.
     *
     */
    private function __construct(string $title, string $description)
    {
        $this->framework = Framework::init(
            'VisitaPorMexico',
            '1.0.0',
            'Arturo López',
            'America/Cancun',
            'es',
        );
        $this->framework->info('Webapp started');
        date_default_timezone_set($this->getFramework()->getTimezone());
        session_start();
        $this->title = $title;
        $this->description = $description;
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
}
