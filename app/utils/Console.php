<?php

namespace App\utils;


class Console
{
    public function run($config=[],$argv=[])
    {
        $router = new RouterConsole();
        $db = new Db($config["db"]);
        App::$db = $db;
        foreach ($config["console"]["routes"] as $route){
            $router->route($route["command"],$route["controller"],$route["action"]);
        }
        //php command.php -c update-courses
        $router->loadRoutes($argv);
    }
}