<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * Functions class.
 *
 * This class contains static methods that can be used throughout the application.
 *
 * @package App
 *
 */
class Functions
{

    /**
     * Displays a dialog box with user information.
     *
     * @return void
     *
     * @uses $_SESSION['user'] The session variable containing user information.
     *
     */
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

    /**
     * Displays a notification message to the user.
     *
     * @return void
     *
     */
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

    /**
     * Creates a notification and stores it in the session.
     *
     * @param string $type The type of the notification.
     * @param string $content The content of the notification.
     *
     * @return bool Returns true if the notification was successfully created and stored in the session, false otherwise.
     *
     */
    public static function createNotification(string $type, string $content): bool
    {
        $_SESSION['notification'] = [
            'type' => $type,
            'content' => $content
        ];
        return true;
    }

    /**
     * Redirects the user to the specified path with optional query parameters.
     *
     * @param string $path The path to redirect to.
     * @param array $params Optional query parameters to include in the redirect URL.
     *
     * @return void
     *
     */
    public static function redirect(string $path, array $params = [])
    {
        $query = null;
        if (!empty($params)) {
            $query = sprintf('?%s', http_build_query($params));
        }
        header(sprintf('Location: %s.php%s', $path, $query));
        exit;
    }

    public static function render(string $view, array $data = []): void
    {
        $view = str_replace('.', DS, $view);
        $view = VIEWS_PATH . DS . $view . '.php';
        if (self::fileNotExists($view)) {
            throw new \Exception(sprintf('View %s not found', $view));
        }
        $object = toObject($data);
        extract($data);
        require_once $view;
    }

    public static function fileExists(string $file): bool {
        // Check if the controller file exists and is readable and is a file
        // The function file_exists() may return true if the file is a directory or a link to a directory
        // This is why we need to check if the file is a file using the is_file() function
        return file_exists($file) && is_readable($file) && is_file($file);
    }

    public static function fileNotExists(string $file): bool {
        return !self::fileExists($file);
    }
}
