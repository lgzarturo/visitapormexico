<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Notification;
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

    public function about(): void
    {
        $data = [
            'title' => 'About',
            'description' => 'About page',
            'content' => 'About page content'
        ];
        // TODO: Remove this code about notifications
        Notification::new('This is a notification message', 'success');
        Notification::new('This is a notification message', 'info');
        Notification::new('This is a notification message', 'warning');
        Notification::new('This is a notification message', 'danger');

        Functions::render('home.about', $data);
    }

    public function notify(): void
    {
        $data = [
            'title' => 'Contact',
            'description' => 'Contact page',
            'content' => 'Contact page content'
        ];
        Functions::render('home.notify', $data);
    }
}
