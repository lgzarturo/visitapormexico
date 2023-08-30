<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Core\{Application, Database};
use App\Helpers\Functions;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Update class.
 *
 * This class represents a utility that updates a user in the database.
 *
 * @package App\Crud\Users
 *
 */
class Update
{
    /**
     * Update user data in the database.
     *
     * @param array $data An array containing user data to be updated.
     * Commonly the data comes from the $_POST super global.
     *
     * @throws \Exception If user data is invalid or user is not found.
     *
     * @return void
     *
     */
    public static function execute(array $data)
    {
        $page = Application::init('Update User', '/users/update');
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
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $name = htmlspecialchars($data['name']);
            $email = htmlspecialchars($data['email']);
            $status = htmlspecialchars($data['status']);
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
            $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $user = $statement->fetch(\PDO::FETCH_ASSOC);
            if (empty($user)) {
                throw new \Exception('User not found');
            }
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
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', 'Error in query to the database');
            Functions::redirect('/users', ['error' => true]);
        } catch (\Exception $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', $e->getMessage());
            Functions::redirect('/users', ['error' => true]);
        }
    }
}

// This is the entry point of the script using the $_POST super global.
Update::execute($_POST);
