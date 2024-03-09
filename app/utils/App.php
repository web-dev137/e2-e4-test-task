<?php

namespace App\utils;

final class App
{
    public static Db $db;
    private static array $post;
    public static bool $appModeTest = false;
    public  function run($config=[])
    {
        self::setDb($config);
        self::setPost();
        foreach($config["routes"] as $route) {
            Router::route($route["uri"],$route["controller"],$route["action"]);
        }
        Router::loadRoutes();
    }

    private  static function setPost()
    {
        $json = file_get_contents('php://input');//for curl
        $post = json_decode($json, true);
        $post = ($_POST)?:$post;
        self::$post = ($post)?:[];
    }
    public static function setDb($config=[],$test = false)
    {
        self::$db = (self::$appModeTest===true)? new Db($config["db_test"]):new Db($config["db"]);
    }

    public static function getPostParams(): array
    {
        return (!empty(self::$post))?self::$post:[];
    }

    public static function setMode($modeTest=true)
    {
        self::$appModeTest=$modeTest;
    }

}