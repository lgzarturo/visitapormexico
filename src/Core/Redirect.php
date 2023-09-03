<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Redirect class.
 *
 * The Redirect class provides a simple way to redirect users to a new location.
 *
 * @package App\Core
 *
 */
class Redirect {
    private string $location;

    public function __construct(string $location) {
        $this->location = $location;
    }

    /**
     * Redirects the user to the specified location.
     *
     * @param string $location The location to redirect to.
     *
     * @return void
     *
     */
    public static function to(string $location): void {
        $location = str_replace('.', DS, $location);
        $self = new self($location);
        $params = "?uri=" . $self->location;
        $url = BASE_URL . $params;

        if (headers_sent()) {
            echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
            echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '" /></noscript>';
            exit;
        }

        if (strpos($self->location, 'http') !== false) {
            header('Location: ' . $self->location);
            exit;
        }

        header('Location: ' . $url);
        exit;
    }
}
