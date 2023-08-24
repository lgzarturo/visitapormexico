<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Photo
{
    private string $title;
    private string $alt;
    private string $description;
    private string $image;

    public function __construct()
    {
        echo 'Photo class instantiated';
    }
}
