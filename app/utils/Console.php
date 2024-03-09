<?php

namespace App\utils;


final class Console
{

    public function run($config=[],$argv=[]): bool
    {
        $router = new RouterConsole();
        $passedArguments = count($argv);//php command.php -c <your command> <--param1=val1 --param2=val2...>
        if($argv && $passedArguments>=3) {
            App::setDb($config);
            $this->setRoutes($config,$router);
            $router->loadRoutes($argv);
            return true;
        } else{
            echo "3 arguments must be passed". $passedArguments ."passed";
            return false;
        }
    }


    /**
     * Set routes for router of commands
     * @param array $config
     * @param RouterConsole $router
     */
    private function setRoutes(array $config,RouterConsole $router)
    {
        foreach ($config["console"]["routes"] as $route) {
            $router->route($route["command"], $route["controller"], $route["action"]);
        }
    }
}