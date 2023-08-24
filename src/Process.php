<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class Process
{
    public function __construct()
    {
        echo 'Process class loaded';
    }

    /**
     * This method will print Hello World
     * @return void
     */
    final public function hello(): void
    {
        echo 'Hello World';
    }
}
