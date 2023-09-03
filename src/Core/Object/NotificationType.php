<?php

declare(strict_types=1);

namespace App\Core\Object;

/**
 * NotificationType enum.
 *
 * NotificationType is an enumeration of string values that represent different types of notifications.
 * The available types are [SUCCESS, INFO, WARNING, and DANGER].
 *
 * @package App\Core\Object
 *
 */
enum NotificationType : string {
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    case DANGER = 'danger';
}
