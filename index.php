<?php
use App\utils\App;
require_once __DIR__."/vendor/autoload.php";
$config = include __DIR__."/config/config.php";
(new App)->run($config);
