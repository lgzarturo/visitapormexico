<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use Exception;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * ListItems class.
 *
 * This class represents a utility that returns an array of all users in the database, ordered by id in descending order.
 *
 * @package App\Crud\Users
 *
 */
class ListItems
{
    /**
     * Returns an array of all users in the database, ordered by id in descending order.
     *
     * @throws \PDOException If there is an error with the database connection or query.
     * @throws Exception If there is an error in the query to the database or in the database connection.
     *
     * @return array An array of all users in the database.
     *
     */
    public static function getAll(): array
    {
        try {
            $connection = Database::connect();
            $sql = 'SELECT * FROM users ORDER BY id DESC';
            $statement = $connection->prepare($sql);
            $statement->execute();
            $users = $statement->fetchAll();
            $connection = null;
            return $users;
        } catch (\PDOException $e) {
            throw new Exception(sprintf('Error in query to the database: %s', $e->getMessage()));
        } catch (\Exception $e) {
            throw new Exception(sprintf('Error in the database connection: %s', $e->getMessage()));
        }
    }
}
