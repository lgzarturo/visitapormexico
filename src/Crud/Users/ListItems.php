<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Database;
use Exception;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class ListItems
{
    public function __construct()
    {
        echo 'List Items User';
    }

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
