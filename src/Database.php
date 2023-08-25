<?php

declare(strict_types=1);

namespace App;

use PDO;

require_once dirname(__DIR__) . '/vendor/autoload.php';

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
     * @return PDO The PDO object representing the database connection.
     */
    public static function connect(): PDO
    {
        try {
            $self = new self('root', 'ATJ-pfGU%2rT_A*Erd', 'user_products', '127.0.0.1', 3307);
            $self->connection = new PDO($self->dsn, $self->user, $self->password);
            $self->connection->exec(sprintf("SET NAMES '%s'", $self->charset));
            $self->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $self->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $self->connection;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
