<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Object\Notification as Notify;

class Notification
{
    private string $defaultType = 'info';

    public static function new(string $message, string $type): void
    {
        $self = new self();

        if ($type === null) {
            $type = $self->defaultType;
        }

        $_SESSION['notification'][] = Notify::new($message, $type);
    }

    public static function alerts(array $messages, string $type): void
    {
        foreach ($messages as $message) {
            self::new($message, $type);
        }
    }

    public static function get(): array
    {
        $notifications = $_SESSION['notification'] ?? [];
        if (isset($_SESSION['notification'])){
            unset($_SESSION['notification']);
        }
        return $notifications;
    }
}
