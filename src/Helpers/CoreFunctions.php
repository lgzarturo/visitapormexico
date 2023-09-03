<?php

use App\Helpers\Functions;

/**
 * Generates a random password consisting of 8 characters from the set of lowercase and uppercase letters and digits.
 *
 * @return string The generated password.
 *
 */
function getRandomPassword() {
    $password = '';
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charsLength = strlen($chars);
    for ($i = 0; $i < 8; $i++) {
        $password .= $chars[rand(0, $charsLength - 1)];
    }
    return $password;
}

/**
 * Debugs the given data and stops the script execution.
 *
 * @param mixed $data The data to be debugged.
 *
 * @return void
 *
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

/**
 * Converts an array to an object.
 *
 * @param array $array The array to be converted.
 *
 * @return object The resulting object.
 *
 */
function toObject(array $array): object {
    if (empty($array)) {
        return new stdClass();
    }
    return json_decode(json_encode($array));
}

/**
 * Checks if a file exists.
 *
 * @param string $file The path to the file to check.
 *
 * @return bool True if the file exists, false otherwise.
 *
 */
function fileExists(string $file): bool {
    return Functions::fileExists($file);
}

/**
 * Checks if a file does not exist.
 *
 * @param string $file The path to the file to check.
 *
 * @return bool Returns true if the file does not exist, false otherwise.
 *
 */
function fileNotExists(string $file): bool {
    return Functions::fileNotExists($file);
}
