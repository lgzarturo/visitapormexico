<?php

declare(strict_types=1);

namespace App\Core\Object;

class Notification {
    private NotificationType $type;
    private string $message;

    private function __construct(string $message, NotificationType $type) {
        $this->type = $type;
        $this->message = $message;
    }

    public function getType(): NotificationType {
        return $this->type;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function __toString(): string {
        return $this->message;
    }

    public static function new(string $message, string $type): Notification {
        return new self($message, self::getValidType($type));
    }

    public static function getValidType(string $type) {
        $defaultType = NotificationType::INFO;
        if ($type === null) {
            return $defaultType;
        }
        if (empty($type)) {
            return $defaultType;
        }
        foreach (NotificationType::cases() as $case) {
            if ($case->value === $type) {
                return $case;
            }
        }
        return $defaultType;
    }
}
