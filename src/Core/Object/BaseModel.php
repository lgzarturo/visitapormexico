<?php

declare(strict_types=1);

namespace App\Core\Object;

use App\Core\Database;

class BaseModel extends Database
{
    public function __construct()
    {
        parent::connect();
    }
}
