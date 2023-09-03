<?php

declare(strict_types=1);

namespace App\Core\Object;

class TokenCsrf
{
    private string $value;
    private int $length;
    private int $expiration;

    public function __construct(string $value, int $length, int $expiration)
    {
        $this->value = $value;
        $this->length = $length;
        $this->expiration = $expiration;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getExpiration(): int
    {
        return $this->expiration;
    }
}
