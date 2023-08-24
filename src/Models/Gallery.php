<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Gallery
{
    private string $title;
    private string $description;
    private string $type;
    private array $photos;

    public function __construct()
    {
        echo 'Gallery class instantiated';
    }
}
