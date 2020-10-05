<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\View;
use App\Core\Authorization;

abstract class AbstractController
{
    protected $view;
    protected $authorization;

    public function __construct()
    {
        $this->view = new View();
        $this->authorization = Authorization::getInstance();
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
