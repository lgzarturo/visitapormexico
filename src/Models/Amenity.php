<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Amenity
{
    private string $name;
    private string $description;
    private string $image;
    private string $icon;

    public function __construct()
    {
        echo 'Amenity class instantiated';
    }
}
