<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * HomeController class.
 *
 * Represents a web page, is the base class for all web pages.
 *
 * @package App\Controllers
 *
 */
class HomeController implements ControllerInterface
{
    public function index(): void
    {
        require_once VIEWS_PATH . DS . 'home.php';
    }
}
