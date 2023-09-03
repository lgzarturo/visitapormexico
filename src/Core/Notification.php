<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Object\Notification as Notify;

/**
 * Notification class.
 *
 * The Notification class provides methods to create and retrieve notifications.
 *
 * @package App\Core
 *
 */
class Notification
{
    private string $defaultType = 'info';

    /**
     * Creates a new notification with the given message and type.
     *
     * @param string $message The message to display in the notification.
     * @param string $type The type of the notification (e.g. success, error, warning).
     *                     If null, the default type will be used.
     *
     * @return void
     *
     */
    public static function new(string $message, string $type): void
    {
        $self = new self();

        if ($type === null) {
            $type = $self->defaultType;
        }

        $_SESSION['notification'][] = Notify::new($message, $type);
    }

    /**
     * Sends alerts for an array of messages with a specified type.
     *
     * @param array $messages An array of messages to send alerts for.
     * @param string $type The type of alert to send.
     *
     * @return void
     *
     */
    public static function alerts(array $messages, string $type): void
    {
        foreach ($messages as $message) {
            self::new($message, $type);
        }
    }

    /**
     * Retrieves the notifications stored in the session and removes them from the session.
     *
     * @return array The notifications stored in the session.
     *
     */
    public static function get(): array
    {
        $notifications = $_SESSION['notification'] ?? [];
        if (isset($_SESSION['notification'])){
            unset($_SESSION['notification']);
        }
        return $notifications;
    }
}
