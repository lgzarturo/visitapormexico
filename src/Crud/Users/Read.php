<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Read class.
 *
 * This class represents a utility that reads a user from the database.
 *
 * @package App\Crud\Users
 *
 */
class Read
{
    /**
     * Retrieves a user from the database and stores it in the session.
     *
     * @param array $data An array containing the user ID.
     * Commonly the data comes from the $_GET super global.
     *
     * @throws \Exception If the user ID is invalid or the user is not found.
     * @throws \PDOException If there is an error executing the SQL statement.
     *
     * @return void
     *
     */
    public static function getUser(array $data): void
    {
        $page = WebPage::init('Read User', '/users/read');
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
            // Store the user in the session.
            $_SESSION['user'] = $user;
            Functions::createNotification('success', sprintf('User %s loaded successfully', $id));
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

// This is the entry point of the script using the $_GET super global.
Read::getUser($_GET);
