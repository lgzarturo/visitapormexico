<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Functions;

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
        $data = [
            'title' => 'Home',
            'description' => 'Home page',
            'content' => 'Home page content'
        ];
        Functions::render('home.index', $data);
    }
}
