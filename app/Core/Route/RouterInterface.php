<?php

namespace App\Core\Route;

interface RouterInterface
{
    public function match(string $pathInfo);
}
