<?php

namespace App\utils;


final class Router
{
    private static array $routes = [];
    public static function route(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes[$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    public  static function loadRoutes()
    {
        $uri = '/'.$_GET["q"];
        $methodExist = self::$routes[$uri] && method_exists(
                self::$routes[$uri]["controller"],
                self::$routes[$uri]["action"]
            );
        ($methodExist)?
            $response = self::callAction($uri):
            $response = Response::notFoundErr();
        echo $response;
    }

    private static function callAction(string $uri): bool|string
    {
        $route = self::$routes[$uri];
        $c = $route["controller"];
        $a = $route["action"];
        $data = match ($_SERVER["REQUEST_METHOD"]) {
            //"PATCH" =>
            default => ($route["params"])?call_user_func_array([(new $c),$a],$route["params"])
                : call_user_func([(new $c),$a])
        };
        return json_encode(["data"=>$data]);
    }

}