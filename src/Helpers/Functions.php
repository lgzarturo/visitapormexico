<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Core\Notification;
use App\Core\Redirect;

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
        $notifications = Notification::get();
        if (empty($notifications)) {
            return;
        }
        $notificationsHtml = '';
        if (empty($notifications)) {
            return;
        }
        foreach ($notifications as $notification) {
            if (!$notification instanceof \App\Core\Object\Notification) {
                continue;
            }
            $item = '
            <div class="notification">
                <p class="notification__text notification--%s">%s</p>
            </div>
            ';
            $notificationsHtml .= sprintf($item, $notification->getType()->value, $notification->getMessage());
        }
        $templateHtml = '<div class="container">%s</div>';
        echo sprintf($templateHtml, $notificationsHtml);
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
        Notification::new($content, $type);
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
        Redirect::to(sprintf('%s.php%s', $path, $query));
        exit;
    }

    /**
     * Renders a view with the given data.
     *
     * The variable $object is used to convert the associative array $data to an object.
     * This allows us to access the data in the view using the object's properties.
     *
     * @param string $view The name of the view file to render.
     * @param array $data An associative array of data to be passed to the view.
     *
     * @throws \Exception If the view file does not exist.
     *
     * @return void
     *
     */
    public static function render(string $view, array $data = []): void
    {
        $view = str_replace('.', DS, $view);
        $view = VIEWS_PATH . DS . $view . '.php';
        if (self::fileNotExists($view)) {
            throw new \Exception(sprintf('View %s not found', $view));
        }
        $object = toObject($data);
        extract($data);
        ob_start();
        include_once $view;
        echo self::loadLayout(ob_get_clean(), $object);
    }

    /**
     * Loads a layout file and replaces its placeholders with the provided content and object properties.
     *
     * @param string $content The content to be inserted into the layout file.
     * @param object $object An object containing properties to be used as placeholders in the layout file.
     *
     * @throws \Exception If the layout file specified in the "extends" tag is not found.
     *
     * @return string The final HTML content with all placeholders replaced.
     */
    private static function loadLayout(string $content, object $object): string
    {
        $pattern = '/{{ extends:(.*) }}/';
        $matches = [];
        preg_match($pattern, $content, $matches);
        if (empty($matches)) {
            return $content;
        }
        $matches = array_map('trim', $matches);
        $layoutName = isset($matches[1]) ? $matches[1] : '';
        $content = str_replace("{{ extends:$layoutName }}", '', $content);
        $layoutPath = LAYOUTS_PATH . DS . "$layoutName.html";

        if (self::fileNotExists($layoutPath)) {
            throw new \Exception(sprintf('Layout %s not found', $layoutName));
        }

        $lang = $object->lang ?? ($_SESSION['lang'] ?? 'es');
        $theme = $object->theme ?? ($_SESSION['theme'] ?? 'dark');
        $title = $object->title ?? '';
        $description = $object->description ?? '';
        $header = $object->header ?? '';
        $footer = $object->footer ?? '';
        $version = $object->version ?? '';

        $html = file_get_contents($layoutPath);

        $replacements = [
            '{{ lang }}' => $lang,
            '{{ theme }}' => $theme,
            '{{ title }}' => $title,
            '{{ description }}' => $description,
            '{{ header }}' => $header,
            '{{ content }}' => $content,
            '{{ footer }}' => $footer,
            '{{ version }}' => $version,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $html);
    }

    /**
     * Checks if a file exists and is readable and is a file.
     *
     * @param string $file The file path to check.
     *
     * @return bool Returns true if the file exists and is readable and is a file, false otherwise.
     *
     */
    public static function fileExists(string $file): bool {
        // Check if the controller file exists and is readable and is a file
        // The function file_exists() may return true if the file is a directory or a link to a directory
        // This is why we need to check if the file is a file using the is_file() function
        return file_exists($file) && is_readable($file) && is_file($file);
    }

    /**
     * Checks if a file does not exist.
     *
     * @param string $file The path to the file to check.
     *
     * @return bool Returns true if the file does not exist, false otherwise.
     *
     */
    public static function fileNotExists(string $file): bool {
        return !self::fileExists($file);
    }
}
