<?php

namespace system\router;

use ReflectionMethod;

class Routing
{
    private $currentRoute;

    public function __construct()
    {
        $this->currentRoute = explode('/', CURRENT_ROUTE);
    }

    // get name of class and check if this class exit or not
    public function run()
    {
        $path = realpath(dirname(__FILE__) . "/../../application/controller/" . $this->currentRoute[2] . ".php");
        if (!file_exists($path)) {
            header("location:error404.php?wrong=10");
            exit;
        }

        require_once($path);
        sizeof($this->currentRoute) == 2 ? $method = "home" : $method = $this->currentRoute[3];
        $classPath = "application\controller\\" . $this->currentRoute[2];
        $class = new $classPath();

        // if method exit get id
        if (method_exists($class, $method)) {
            $reflection = new ReflectionMethod($classPath, $method);
            $paramCount = $reflection->getNumberOfParameters();
            if ($paramCount <= count(array_slice($this->currentRoute, 2)))
                call_user_func(array($class, $method), array_slice($this->currentRoute, 2));
            else
                echo "parameter error!!";

        } else
            echo "method not exists!!";
    }

    public function error404()
    {
        http_response_code(404);
        include realpath(dirname(__FILE__) . "/../../application/view/error404.php");
        exit;
    }
}