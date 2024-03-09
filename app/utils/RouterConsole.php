<?php
namespace App\utils;

use App\console\UpdateCourses;

final class RouterConsole
{

    private static array $routes = [];

    /**
     * Here we save routes for console commands
     * @param string $command
     * @param string $controller
     * @param string $action
     * @param array $params
     */
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

    /**
     * Redirect to your handler
     * @param array $argv
     * @return bool
     */
    public function loadRoutes(array $argv): bool
    {
        $route_key = $argv[2];//your command

        if( count($argv) >= 3
            && $argv[1] == "-c"
            && $argv[2]
            && isset(self::$routes[$route_key])) {
            $route = self::$routes[$route_key];

            if(method_exists($route["controller"],$route["action"])) {
                $params = $this->parseArg($argv);
                $res=($params)?
                    call_user_func_array([(new $route["controller"]),$route["action"]],$params)
                    : call_user_func([(new $route["controller"]),$route["action"]
                        ]);
                echo ($res)?"success":"fail";
                return $res;
            }
        }
        echo "wrong command";
        return false;
    }

    /**
     * parse params like --param=val1 --param2=val2
     * @param array $argv
     * @return array
     */
    private function parseArg(array $argv): array
    {
        $my_args = [];
        for ($i = 1; $i < count($argv); $i++) {
            if (preg_match('/^--([^=]+)=(.*)/', $argv[$i], $match)) {
                $my_args[$match[1]] = $match[2];
            }
        }
        return $my_args;
    }

}
