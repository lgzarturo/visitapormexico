<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * This class is the entry point of the webapp
 * @package App
 */
class WebPage
{
    private Framework $framework;
    private string $title;
    private string $description;

    private function __construct(string $title, string $description)
    {
        $this->framework = Framework::init(
            'VisitaPorMexico',
            '1.0.0',
            'Arturo López'
        );
        $this->framework->info('Webapp started');
        session_start();
        $this->title = $title;
        $this->description = $description;
    }

    final public static function init(string $title, string $description): self
    {
        return new self($title, $description);
    }

    final public function getFramework(): Framework
    {
        return $this->framework;
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    final public function getDescription(): string
    {
        return $this->description;
    }
}
