<?php

use App\Helpers\Functions;

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

function toObject(array $array): object {
    if (empty($array)) {
        return new stdClass();
    }
    return json_decode(json_encode($array));
}

function fileExists(string $file): bool {
    return Functions::fileExists($file);
}

function fileNotExists(string $file): bool {
    return Functions::fileNotExists($file);
}
