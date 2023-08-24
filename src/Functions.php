<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class Functions
{

    public static function createNotification(string $type, string $content): bool
    {
        $_SESSION['notification'] = [
            'type' => $type,
            'content' => $content
        ];
        return true;
    }

    public static function redirect(string $path, array $params = [])
    {
        $query = null;
        if (!empty($params)) {
            $query = sprintf('?%s', http_build_query($params));
        }
        header(sprintf('Location: %s.php%s', $path, $query));
        exit;
    }
}
