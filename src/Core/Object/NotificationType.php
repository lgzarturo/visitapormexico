<?php

declare(strict_types=1);

namespace App\Core\Object;

enum NotificationType : string {
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    case DANGER = 'danger';
}
