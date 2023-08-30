<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Create class
 *
 * This class contains a static method `execute` that creates a new user in the database.
 *
 * @package App\Crud\Users
 *
 */
class Create
{
    /**
     * Creates a new user in the database with the provided data.
     *
     * @param array $data An associative array containing the user's name, email and status.
     * Commonly the data comes from the $_POST super global.
     *
     * @throws \PDOException If there is an error with the database connection or query.
     * @throws \Exception If any of the required fields are missing or invalid.
     *
     * @return void
     *
     */
    public static function execute(array $data)
    {
        $page = WebPage::init('Create User', '/users/create');
        try {
            if (empty($data)) {
                throw new \Exception('All fields are required');
            }

            if (!isset($data['name']) || !isset($data['email']) || !isset($data['status'])) {
                throw new \Exception('All fields are required');
            }
            array_map('trim', $data);
            $name = htmlspecialchars($data['name']);
            $email = $data['email'];
            $status = $data['status'];

            if (empty($name) || empty($email) || empty($status)) {
                throw new \Exception('All fields are required');
            }
            if (strlen($name) < 3) {
                throw new \Exception('Name must be at least 3 characters long');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email');
            }
            if (!in_array($status, ['active', 'inactive'])) {
                throw new \Exception('Invalid status');
            }
            $connection = Database::connect();
            $sql = 'INSERT INTO users (name, email, status, creation_date) VALUES (:name, :email, :status, NOW())';
            $statement = $connection->prepare($sql);
            $statement->bindParam('name', $name, \PDO::PARAM_STR);
            $statement->bindParam('email', $email, \PDO::PARAM_STR);
            $statement->bindParam('status', $status, \PDO::PARAM_STR);
            $statement->execute();
            $id = $connection->lastInsertId();
            $connection = null;
            $page->getFramework()->info(sprintf('User %s created successfully', $id));
            Functions::createNotification('success', sprintf('User %s created successfully', $id));
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
Create::execute($_POST);
