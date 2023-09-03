<?php

declare(strict_types=1);

namespace App\Core;

class Redirect {
    private string $location;

    public function __construct(string $location) {
        $this->location = $location;
    }

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
