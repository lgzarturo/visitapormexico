<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Object\TokenCsrf;

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
    private TokenCsrf $csrfToken;
    private string $csrfTokenName = 'csrf_token';
    private int $csrfTokenLength = 32;
    private int $csrfTokenExpiration = 60 * 5;

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

    private function generateRandomString(int $length = 32): string
    {
        if (function_exists('random_bytes')) {
            $randomString = bin2hex(random_bytes($length));
        } else {
            $randomString = bin2hex(openssl_random_pseudo_bytes($length));
        }
        return $randomString;
    }

    public function generateCSRFToken(): TokenCsrf
    {
        $token = $this->generateRandomString($this->csrfTokenLength);
        $tokenExpiration = time() + $this->csrfTokenExpiration;
        $tokenCsrf = new TokenCsrf($token, $this->csrfTokenLength, $tokenExpiration);
        $_SESSION[$this->csrfTokenName] = $tokenCsrf;
        $this->csrfToken = $tokenCsrf;
        return $tokenCsrf;
    }

    public function getCSRFToken(): TokenCsrf
    {
        return $this->csrfToken;
    }

    public function generateSalt(): string
    {
        $salt = '$2y$10$' . $this->generateRandomString(22) . '$';
        $_SESSION['salt'] = $salt;
        $this->salt = $salt;
        return $salt;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public static function init(): Security
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return new Security();
    }

    public function validateCSRFToken(string $token): bool
    {
        if (isset($_SESSION[$this->csrfTokenName])) {
            $tokenCsrf = $_SESSION[$this->csrfTokenName];
            if ($tokenCsrf->getToken() === $token && $tokenCsrf->getExpiration() > time()) {
                return true;
            }
        }
        return false;
    }
}
