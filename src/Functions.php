<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class Functions
{

    public static function showNotification(): void
    {
        $template_html = '
        <div class="container">
            <div class="notification">
                <p class="notification__text notification--%s">%s</p>
            </div>
        </div>
        ';
        if (isset($_SESSION['notification'])) {
            $notification = $_SESSION['notification'];
            echo sprintf($template_html, $notification['type'], $notification['content']);
            unset($_SESSION['notification']);
        }
    }

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
