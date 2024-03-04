<?php

namespace App\utils;


class Router
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

        if (
                self::$routes[$uri]
                && method_exists(self::$routes[$uri]["controller"], self::$routes[$uri]["action"])
            ) {
                $route = self::$routes[$uri];
                $c = $route["controller"];
                $a = $route["action"];
                $data = match ($_SERVER["REQUEST_METHOD"]) {
                    //"PATCH" =>
                    default => ($route["params"])?call_user_func_array([(new $c),$a],$route["params"])
                        : call_user_func([(new $c),$a])
                };
            $response = json_encode(["data"=>$data]);
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $response = http_response_code(404);
        }
        echo $response;
    }


}