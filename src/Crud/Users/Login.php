<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class Login
{
    public function __construct()
    {
        echo 'Login User';
    }

    public static function authentication(): void
    {
        if (!isset($_SESSION['current_user'])) {
            Functions::createNotification('error', 'You must be logged in to access this page');
            Functions::redirect('/users/login');
        }
    }

    public static function getCurrentUser(array $data): void
    {
        $page = WebPage::init("Get Current User", "/users/current");
        try {
            $user = [];
            if (!isset($_SESSION['current_user'])) {
                throw new \Exception('There is no user logged in');
            } else {
                $user = $_SESSION['current_user'];
            }
            if (empty($user)) {
                throw new \Exception('There is no user logged in');
            }

            $connection = Database::connect();
            $sql = 'SELECT * FROM users WHERE id = :id';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $user['id'], \PDO::PARAM_INT);
            $statement->execute();
            $user = $statement->fetch(\PDO::FETCH_ASSOC);
            $connection = null;
            if (empty($user)) {
                throw new \Exception('User not found');
            }
            $_SESSION['current_user'] = $user;
            Functions::createNotification('success', sprintf('User %s loaded successfully', $user['id']));
            Functions::redirect('/index');
        } catch (\Exception $e) {
            Functions::createNotification('error', $e->getMessage());
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf("Error: %s", $e->getMessage()));
            Functions::createNotification('error', 'Server error');
        }
    }
}
