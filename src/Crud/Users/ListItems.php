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
     * @return array An array of all users in the database.
     * @throws Exception If there is an error executing the SQL statement.
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
            throw new Exception($e->getMessage());
        }
    }
}
