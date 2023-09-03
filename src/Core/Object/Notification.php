<?php

declare(strict_types=1);

namespace App\Core\Object;

/**
 * NotificationType enum.
 *
 * Represents a notification object that contains a message and a type.
 *
 * @package App\Core\Object
 *
 */
class Notification {
    /**
     * The type of the notification.
     *
     * @var NotificationType
     *
     */
    private NotificationType $type;

    /**
     * The message of the notification.
     *
     * @var string
     *
     */
    private string $message;

    /**
     * Constructs a new Notification object.
     *
     * @param string $message The message of the notification.
     * @param NotificationType $type The type of the notification.
     *
     */
    private function __construct(string $message, NotificationType $type) {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Returns the type of the notification.
     *
     * @return NotificationType The type of the notification.
     *
     */
    public function getType(): NotificationType {
        return $this->type;
    }

    /**
     * Returns the message of the notification.
     *
     * @return string The message of the notification.
     *
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * Returns the message of the notification as a string.
     *
     * @return string The message of the notification.
     *
     */
    public function __toString(): string {
        return $this->message;
    }

    /**
     * Creates a new Notification object with the given message and type.
     *
     * @param string $message The message of the notification.
     * @param string $type The type of the notification.
     *
     * @return Notification The new Notification object.
     *
     */
    public static function new(string $message, string $type): Notification {
        return new self($message, self::getValidType($type));
    }

    /**
     * Returns a valid NotificationType object for the given type string.
     *
     * @param string $type The type string to validate.
     *
     * @return NotificationType The valid NotificationType object.
     *
     */
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
