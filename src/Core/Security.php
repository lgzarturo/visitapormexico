<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Security class.
 *
 * The Security class provides a simple interface for generating security tokens.
 *
 * @package App
 *
 */
class Security
{
    private string $key;
    private string $salt;
    private string $csrfToken;

    private function __construct()
    {
        $this->key = $this->generateKey();
        $this->salt = $this->generateSalt();
        $this->csrfToken = $this->generateCSRFToken();
    }

    public function generateKey(): string
    {
        // TODO: This value should be stored in a .env file and loaded from there.
        return 'A2992-2347D-5F64F-6A7A2-8B8B8-GUQoWpRuYyQ-*s[8j7Us^%$#+!@';
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function generateCSRFToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public function getCSRFToken(): string
    {
        return $this->csrfToken;
    }

    public function generateSalt(): string
    {
        $salt = '$2y$10$' . bin2hex(random_bytes(22)) . '$';
        $_SESSION['salt'] = $salt;
        return $salt;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public static function init(): Security
    {
        return new Security();
    }
}
