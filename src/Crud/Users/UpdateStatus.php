<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Core\{Application, Database};
use App\Helpers\Functions;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * UpdateStatus class.
 *
 * This class contains a static method setStatus that updates the status of a user in the database.
 *
 * @package App\Crud\Users
 *
 */
class UpdateStatus
{
    /**
     * Updates the status of a user in the database.
     *
     * @param array $data An array containing the user ID and the new status.
     * Commonly the data comes from the $_GET super global.
     *
     * @throws \Exception If the user ID or status is invalid, or if the user is not found in the database.
     *
     * @return void
     *
     */
    public static function setStatus(array $data)
    {
        $page = Application::init('Update status User', '/users/update/status');
        try {
            array_map('trim', $data);
            if (!isset($data['id'])) {
                throw new \Exception('Invalid user');
            }
            if (!isset($data['status'])) {
                throw new \Exception('Invalid status');
            }
            $id = (int) $data['id'];
            $status = $data['status'];
            if ($id <= 0) {
                throw new \Exception('Invalid user');
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
            $sql = 'UPDATE users SET status = :status WHERE id = :id';
            $statement = $connection->prepare($sql);
            $statement->bindParam('id', $id, \PDO::PARAM_INT);
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

// This is the entry point of the script using the $_GET super global.
UpdateStatus::setStatus($_GET);
