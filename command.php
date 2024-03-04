<?php
require_once __DIR__."/vendor/autoload.php";
$config = include __DIR__."/config/config.php";

(new \App\utils\Console())->run($config,$argv);




