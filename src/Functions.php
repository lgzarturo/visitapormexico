<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class Functions
{

    public static function showUser()
    {
        $template_html = '
        <dialog id="user_dialog">
            <div class=" dialog__overlay">
            </div>
            <div class="dialog__content">
                <div class="dialog__header">
                    <h2 class="dialog__title">User</h2>
                    <button class="dialog__close" aria-label="close">&times;</button>
                </div>
                <div class="dialog__body">
                    <p>User: %s</p>
                    <p>Email: %s</p>
                    <p>Status: %s</p>
                    <p>Date: %s</p>
                </div>
                <div class="dialog__footer">
                    <button class="btn btn--primary">Button</button>
                </div>
            </div>
        </dialog>
        ';
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            echo sprintf($template_html, $user['name'], $user['email'], $user['status'], $user['creation_date']);
            unset($_SESSION['user']);
        }
    }

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
