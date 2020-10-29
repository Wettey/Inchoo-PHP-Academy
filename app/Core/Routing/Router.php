<?php

namespace App\Core\Routing;

use App\Core\Exception\RouterException;

class Router implements RouterInterface
{
    public function match(string $pathInfo)
    {
        $pathInfo = trim($pathInfo, '/');
        $parts = $pathInfo ? explode('/', $pathInfo) : [];

        if (count($parts) > 2) {
            throw new RouterException('Not a valid URL');
        }

        $controller = ucfirst(strtolower($parts[0] ?? 'theme')) . 'Controller';
        $method = strtolower($parts[1] ?? 'read') . 'Action';

        $className = "\\App\\Controller\\{$controller}";

        if (!method_exists($className, $method)) {
            throw new RouterException('Method does not exist');
        }

        $object = new $className();
        return $object->$method() ?? '';
    }
}
