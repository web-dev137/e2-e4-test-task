<?php
namespace App\utils;

use App\console\UpdateCourses;

class RouterConsole
{

    private static array $routes = [];
    public  function route(
        string $command,
        string $controller,
        string $action,
        array $params=[]
    )
    {
        self::$routes[$command] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }
    public function loadRoutes(array $argv): bool
    {
        $route_key = $argv[2];

        if( count($argv) == 3
            && $argv[1] == "-c"
            && $argv[2]
            && isset(self::$routes[$route_key])) {
            $route = self::$routes[$route_key];

            if(method_exists($route["controller"]
                ,$route["action"])) {
                ($route["params"])?
                    call_user_func_array([(new $route["controller"]),$route["action"]],$route["params"])
                    : call_user_func([(new $route["controller"]),$route["action"]
                        ]);
                echo "success";
                return true;
            }
        }
        echo "wrong command";
        return false;
    }

}
