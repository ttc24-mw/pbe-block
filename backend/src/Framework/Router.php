<?php

namespace Framework;

use Controllers\ControllerInterface;
use Exception;

class Router
{
    private array $routes = [];

    public function add(string $path, string $controllerClass, string $method, $service)
    {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controllerClass,
            'method' => $method,
            'service' => $service
        ];
    }

    public function dispatch()
    {
        $url = $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($url);
        $queryString = $parsedUrl['query'] ?? '';
        parse_str($queryString, $queryParams);
        $action = $queryParams['action'] ?? '';

        foreach ($this->routes as $route) {
            if ($route['path'] === $action) {
                $controllerClass = $route['controller'];

                $GLOBALS['queryParams'] = [];
                if (isset($_SERVER['QUERY_STRING'])) {
                    parse_str($_SERVER['QUERY_STRING'], $GLOBALS['queryParams']);
                }

                $GLOBALS['body'] = json_decode(file_get_contents('php://input'), true);

                // if ($controllerClass instanceof ControllerInterface) {
                    $controller = new $controllerClass($route['service']);
                // } else {
                //     $controller = new $controllerClass();
                // }

                try {
                    $controller->handle();
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }

                return;
            }
        }

        http_response_code(404);
    }
}
