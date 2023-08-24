<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Room
{
    private string $name;
    private string $description;
    private string $image;
    private int $capacity;
    private float $price;
    private string $currency;
    private array $amenities;
    private array $photos;
    private Hotel $hotel;

    public function __construct()
    {
        echo 'Room class instantiated';
    }
}
