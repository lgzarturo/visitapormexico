<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class Read
{
    public function __construct()
    {
        echo 'Read User';
    }

    public static function getUser(array $data): void
    {
        $page = WebPage::init("Read User", "/users/read");
        try {
            array_map('trim', $data);
            if (!isset($data['id'])) {
                throw new \Exception('Invalid user');
            }
            $id = (int) $data['id'];
            if ($id <= 0) {
                throw new \Exception('Invalid user');
            }
            $connection = Database::connect();
            $sql = 'SELECT * FROM users WHERE id = :id';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $user = $statement->fetch(\PDO::FETCH_ASSOC);
            $connection = null;
            if (empty($user)) {
                throw new \Exception('User not found');
            }
            $_SESSION['user'] = $user;
            Functions::createNotification('success', sprintf('User %s loaded successfully', $id));
            Functions::redirect('/users');
        } catch (\Exception $e) {
            Functions::createNotification('error', $e->getMessage());
            Functions::redirect('/users', ['error' => true]);
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf("Error: %s", $e->getMessage()));
            Functions::createNotification('error', 'Server error');
            Functions::redirect('/users', ['error' => true]);
        }
    }
}

Read::getUser($_GET);
