<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use PDO;

/**
 * Database class.
 *
 * The Database class represents a connection to a MySQL database.
 *
 * @property string $engine The database engine.
 * @property string $host The database host.
 * @property int $port The database port.
 * @property string $user The database username.
 * @property string $password The database password.
 * @property string $database The database name.
 * @property string $charset The database charset.
 * @property string $dsn The database DSN.
 * @property PDO $connection The database connection.
 *
 * @package App
 *
 */
class Database
{
    private string $engine;
    private string $host;
    private int $port;
    private string $user;
    private string $password;
    private string $database;
    private string $charset;
    private string $dsn;
    private PDO $connection;

    private function __construct(string $username, string $password, string $database, string $host, int $port)
    {
        $this->engine = 'mysql';
        $this->user = $username;
        $this->password = $password;
        $this->database = $database;
        $this->host = $host;
        $this->port = $port;
        $this->charset = 'utf8mb4';

        $this->dsn = sprintf(
            '%s:host=%s;port=%d;dbname=%s;charset=%s',
            $this->engine,
            $this->host,
            $this->port,
            $this->database,
            $this->charset
        );
    }

    /**
     * Establishes a connection to the database and returns a PDO object.
     *
     * @throws Exception If there is an error connecting to the database.
     *
     * @return PDO The PDO object representing the connection to the database.
     *
     */
    public static function connect(): PDO
    {
        try {
            $self = new self('root', 'ATJ-pfGU%2rT_A*Erd', 'user_products', '127.0.0.1', 3307);
            $self->connection = new PDO($self->dsn, $self->user, $self->password);
            $self->connection->exec("SET NAMES '{$self->charset}'");
            $self->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $self->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $self->connection;
        } catch (\PDOException $e) {
            throw new Exception(sprintf('Error connecting to the database: %s', $e->getMessage()));
        }
    }

    /**
     * Executes a SQL query with optional parameters and returns the results.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params An array of parameters to bind to the query.
     *
     * @throws Exception If the query fails or is invalid.
     *
     * @return array The results of the query, if any.
     *
     */
    public static function query(string $sql, array $params = []): array
    {
        $connection = self::connect();
        $connection->beginTransaction();
        $statement = $connection->prepare($sql);
        // If the query fails, the transaction is rolled back and an exception is thrown.
        if (!$statement->execute($params)) {
            $connection->rollBack();
            $error = $statement->errorInfo();
            $connection = null;
            throw new Exception(sprintf('Error executing query: %s', $error[2]));
        }

        // Handle types of queries, SELECT, INSERT, UPDATE, DELETE and return the results.
        $results = [];
        if (stripos($sql, 'SELECT') === 0) {
            $results = $statement->fetchAll();
        } elseif (stripos($sql, 'INSERT') === 0) {
            $results = ['id' => $connection->lastInsertId()];
            $connection->commit();
        } elseif (stripos($sql, 'UPDATE') === 0 || stripos($sql, 'DELETE') === 0) {
            // TODO: Improve this code to handle UPDATE and DELETE queries without a WHERE clause.
            if (stripos($sql, 'WHERE') === false) {
                throw new Exception('The query must contain a WHERE clause');
            }
            $count = $statement->rowCount();
            if ($count > 0) {
                $results = ['affected_rows' => $statement->rowCount()];
                $connection->commit();
            } else {
                $results = ['affected_rows' => 0];
                $connection->rollBack();
            }
        } else {
            $connection->commit();
        }

        $connection = null;
        return $results;
    }
}
