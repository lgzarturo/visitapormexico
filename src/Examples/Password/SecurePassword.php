<?php

declare(strict_types=1);

namespace App\Examples\Password;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\Functions;
use App\WebPage;

/**
 * SecurePassword class.
 *
 * The SecurePassword class generates a secure password with the following requirements:
 * - At least one special character from the set '!@#$%^&*()_-=+;:,.?'.
 * - At least one number from the set '0123456789'.
 * - At least one lowercase letter from the set 'abcdefghijklmnopqrstuvwxyz'.
 * - At least one uppercase letter from the set 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
 * - At least six characters from the set '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.
 * - The password length must be at least 8 characters and at most 128 characters.
 *
 * @package App\Examples\Password
 *
 */
class SecurePassword
{

    private string $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private string $specialChars = '!@#$%^&*()_-=+;:,.?';
    private int $minSpecialChars = 1;
    private int $minNumbers = 1;
    private int $minLowerChars = 1;
    private int $minUpperChars = 1;
    private int $minChars = 6;
    private int $minLength = 8;
    private int $maxLength = 128;
    private string $password = '';

    public function __construct(int $size)
    {
        $this->minLength = $size;
        $this->generatePassword();
    }

    private function generateSpecialChars(): string
    {
        $password = '';
        for ($i = 0; $i < $this->minSpecialChars; $i++) {
            $password .= $this->specialChars[mt_rand(0, strlen($this->specialChars) - 1)];
        }
        return $password;
    }

    private function generateNumbers(): string
    {
        $password = '';
        for ($i = 0; $i < $this->minNumbers; $i++) {
            $password .= $this->chars[mt_rand(0, strlen($this->chars) - 1)];
        }
        return $password;
    }

    private function generateLowerChars(): string
    {
        $password = '';
        for ($i = 0; $i < $this->minLowerChars; $i++) {
            $password .= strtolower($this->chars[mt_rand(0, strlen($this->chars) - 1)]);
        }
        return $password;
    }

    private function generateUpperChars(): string
    {
        $password = '';
        for ($i = 0; $i < $this->minUpperChars; $i++) {
            $password .= strtoupper($this->chars[mt_rand(0, strlen($this->chars) - 1)]);
        }
        return $password;
    }

    private function generateChars(): string
    {
        $password = '';
        for ($i = 0; $i < $this->minChars; $i++) {
            $password .= $this->chars[mt_rand(0, strlen($this->chars) - 1)];
        }
        return $password;
    }

    /**
     * Generates a secure password with a combination of special characters, numbers, lower and upper case letters.
     *
     * @return string The generated password.
     */
    private function generatePassword(): string
    {
        $this->password = '';
        $this->password .= $this->generateSpecialChars();
        $this->password .= $this->generateNumbers();
        $this->password .= $this->generateLowerChars();
        $this->password .= $this->generateUpperChars();
        $this->password .= $this->generateChars();
        for ($i = 0; $i < $this->minLength; $i++) {
            $this->password .= $this->chars[mt_rand(0, strlen($this->chars) - 1)];
        }
        $this->password = str_shuffle($this->password);
        $this->password = substr($this->password, 0, $this->minLength);
        if (strlen($this->password) > $this->maxLength) {
            $this->password = substr($this->password, 0, $this->maxLength);
        }
        return $this->password;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s',
            $this->password
        );
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function create(int $size): SecurePassword
    {
        return new SecurePassword($size);
    }
}

// In the following snippet, we are using the SecurePassword class to generate a random password.

try {
    $page = WebPage::init("Random Password", "Generate Random Password");
    if ($_POST) {
        array_map('trim', $_POST);
        $size = (int) $_POST['size'] ?? 8;

        if (!isset($size)) {
            throw new \InvalidArgumentException('Invalid size length is required');
        }

        if ($size < 8) {
            throw new \InvalidArgumentException('Invalid size length minimum 8');
        }

        if ($size > 128) {
            throw new \InvalidArgumentException('Invalid size length maximum 128');
        }

        $securePassword = SecurePassword::create($size);
        $_SESSION['password'] = [
            'size' => $size,
            'password' => $securePassword->__toString()
        ];
        Functions::createNotification('success', 'Random Password Generated Successfully');
        Functions::redirect('/password');
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $page->getFramework()->error($error);
    Functions::createNotification('error', $error);
    Functions::redirect('/password', ['error' => true]);
}
