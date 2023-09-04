<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Notification;
use App\Core\Object\BaseController;
use App\Helpers\Functions;
use App\Models\User;
use Exception;

/**
 * HomeController class.
 *
 * Represents a web page.
 *
 * @package App\Controllers
 *
 */
class HomeController  extends BaseController implements ControllerInterface
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

    public function users(): void
    {
        try {
            $res = Database::query('SELECT * FROM users');
            dd($res);
            $res = Database::query('SELECT * FROM users WHERE email = :email', ['email' => 'user8@example.com']);
            dd($res);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function user(): void
    {
        try {
            $user = new User('usuario1', 'user1@gmail.com', 'active', 1);

            $user->add();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function csrf(): void
    {
        dd($_SESSION);
    }

    public function expenses(): void
    {
        $data = [
            'title' => 'Expenses',
            'description' => 'Expenses page',
            'content' => 'Expenses page content'
        ];
        Functions::render('home.expenses', $data);
    }

    public function movements(): void
    {
        $data = [
            'title' => 'Movements',
            'description' => 'Movements page',
            'content' => 'Movements page content'
        ];
        Functions::render('home.movements', $data);
    }
}
