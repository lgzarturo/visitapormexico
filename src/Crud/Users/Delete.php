<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Delete class
 *
 * @package App\Crud\Users
 *
 * This class handles the deletion of a user from the database.
 *
 */
class Delete
{
    /**
     * Deletes a user from the database.
     *
     * @param array $data An array containing the user's id.
     * Commonly the data comes from the $_GET super global.
     *
     * @throws \Exception If the user id is invalid or not found.
     *
     * @return void
     */
    public static function execute(array $data)
    {
        $page = WebPage::init('Delete User', '/users/delete');
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
            $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $user = $statement->fetch(\PDO::FETCH_ASSOC);
            if (empty($user)) {
                throw new \Exception('User not found');
            }
            $sql = 'DELETE FROM users WHERE id = :id';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $connection = null;
            $page->getFramework()->info(sprintf('User %s deleted successfully', $id));
            Functions::createNotification('success', sprintf('User %s deleted successfully', $id));
            Functions::redirect('/users');
        } catch (\Exception $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', $e->getMessage());
            Functions::redirect('/users', ['error' => true]);
        }
    }
}

// This is the entry point of the script using the $_GET super global.
Delete::execute($_GET);
