<?php

namespace App\utils;

class App
{
    public static Db $db;
    private static array $post;
    public  function run($config=[])
    {
        self::$db = new Db($config["db"]);
        self::$post = $_POST;
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