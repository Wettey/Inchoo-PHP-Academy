<?php

namespace App\Core\Routing;

interface RouterInterface
{
    public function match(string $pathInfo);
}
