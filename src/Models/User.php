<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class User
{
    private string $name;
    private string $email;
    private string $status;
    private int $createAt;

    public function __construct()
    {
        echo 'User class instantiated';
    }
}
