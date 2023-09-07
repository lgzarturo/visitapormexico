<?php

declare(strict_types=1);

namespace App\Core\Object;

use App\Core\Application;
use App\Core\Log;

class BaseController
{
    private Application $app;
    protected Log $log;
    protected array $data = [];
    private TokenCsrf $csrfToken;
    private string $salt = '';

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->log = $app->getFramework()->getLog();
        $this->csrfToken = $app->getSecurity()->getCSRFToken();
        $this->salt = $app->getSecurity()->getSalt();
        $this->data = [
            'title' => $this->app->getTitle(),
            'description' => $this->app->getDescription(),
            'footer' => $this->app->getFramework()->getCopyRight(),
            'lang' => $this->app->getFramework()->getLanguage(),
            'salt' => $this->salt,
            'csrfToken' => $this->csrfToken->getValue(),
            'version' => "v{$this->app->getFramework()->getVersion()}",
        ];
    }
}
