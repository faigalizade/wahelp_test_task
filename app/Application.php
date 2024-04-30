<?php

namespace App;
class Application
{

    private array $config;
    private array $routes;
    private Database $database;
    private Request $request;

    public function __construct($isConsole = false)
    {
        $this->loadConfig();
        $this->connectToDatabase();
        if (!$isConsole) {
            $this->createRequest();
            $this->initRoutes();
            $this->handleRequest();
        }
    }

    private function loadConfig(): void
    {
        $this->config = require_once __DIR__ . "/../config/main.php";
    }

    private function connectToDatabase(): void
    {
        $this->database = Database::getInstance($this->config['database']);
    }

    private function createRequest()
    {
        $this->request = Request::getInstance([
            'post' => $_POST,
            'get' => $_GET,
            'files' => $_FILES,
            'body' => json_decode(file_get_contents('php://input'), true) ?? [],
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => explode('?', $_SERVER['REQUEST_URI'])[0],
        ]);
    }

    private function handleRequest()
    {
        if (!array_key_exists($this->request->getMethod(), $this->routes)) {
            http_response_code(404);
            echo "404 method not available";
            return;
        }

        if (!array_key_exists($this->request->getUri(), $this->routes[$this->request->getMethod()])) {
            http_response_code(404);
            echo "404 route not found";
            return;
        }
        $route = $this->routes[$this->request->getMethod()][$this->request->getUri()];
        list($controller, $action) = $route;
        $controller = new $controller(Request::getInstance());
        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo "404 action is not found";
            return;
        }

        $response = $controller->$action();
        if (is_array($response)) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode($response);
        } else {
            echo $response;
        }
    }

    private function initRoutes(): void
    {
        $this->routes = require_once __DIR__."/../routes.php";
    }

    public function exit()
    {

    }
}