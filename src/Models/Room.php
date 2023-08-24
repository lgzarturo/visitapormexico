<?php

namespace App\Models;

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
}
