<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class Update
{
    public function __construct()
    {
        echo 'Update User';
    }

    public static function execute(array $data)
    {
        $page = WebPage::init('Update User', '/users/update');
        try {
            array_map('trim', $data);
            if (!isset($data['id'])) {
                throw new \Exception('Invalid user');
            }
            if (!isset($data['name'])) {
                throw new \Exception('Invalid name');
            }
            if (!isset($data['email'])) {
                throw new \Exception('Invalid email');
            }
            if (!isset($data['status'])) {
                throw new \Exception('Invalid status');
            }
            $id = (int) $data['id'];
            $name = $data['name'];
            $email = $data['email'];
            $status = $data['status'];
            if ($id <= 0) {
                throw new \Exception('Invalid user');
            }
            if (strlen($name) < 3) {
                throw new \Exception('Invalid name');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email');
            }
            if (!in_array($status, ['active', 'inactive'])) {
                throw new \Exception('Invalid status');
            }
            $connection = Database::connect();
            $sql = 'UPDATE users SET name = :name, email = :email, status = :status WHERE id = :id';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
            $statement->bindParam('name', $name, \PDO::PARAM_STR);
            $statement->bindParam('email', $email, \PDO::PARAM_STR);
            $statement->bindParam('status', $status, \PDO::PARAM_STR);
            $statement->execute();
            $connection = null;
            $page->getFramework()->info(sprintf('User %s updated successfully', $id));
            Functions::createNotification('success', sprintf('User %s updated successfully', $id));
            Functions::redirect('/users');
        } catch (\Exception $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', $e->getMessage());
            Functions::redirect('/users', ['error' => true]);
        }
    }
}

Update::execute($_POST);
