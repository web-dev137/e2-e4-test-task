<?php

namespace App\utils;

class App
{
    public static Db $db;
    private static array $post;
    public  function run($config=[])
    {
        self::$db = new Db($config["db"]);
        $json = file_get_contents('php://input');
        $post = json_decode($json, true);

        self::$post = ($_POST)?:$post;
        foreach($config["routes"] as $route) {
            Router::route($route["uri"],$route["controller"],$route["action"]);
        }
        Router::loadRoutes();
    }

    public static function getPostParams(): array
    {
        return self::$post;
    }

}