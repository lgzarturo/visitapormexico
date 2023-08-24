<?php

namespace App;

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
