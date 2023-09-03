<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Object\BaseModel;
use Exception;

class User extends BaseModel
{
    private string $name;
    private string $email;
    private string $status;
    private int $createAt;

    public function __construct(string $name, string $email, string $status, int $createAt)
    {
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
        $this->createAt = $createAt;
        parent::__construct();
    }

    public function add(): void
    {
        // TODO: Add createAt date in the query for the user creation
        $sql = 'INSERT INTO users (name, email, status) VALUES (:name, :email, :status)';
        try {
            $result = parent::query($sql, [
                ':name' => $this->name,
                ':email' => $this->email,
                ':status' => $this->status
            ]);
            dd($result);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
