<?php

declare(strict_types=1);

namespace App\Models;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Hotel
{
    private string $name;
    private string $phone;
    private string $email;
    private string $website;
    private string $description;
    private string $image;
    private string $address;
    private string $city;
    private string $state;
    private string $country;
    private string $zipCode;
    private string $latitude;
    private string $longitude;
    private int $stars;
    private float $price;
    private string $currency;
    private array $rooms;

    public function __construct()
    {
        echo 'Hotel class instantiated';
    }
}
