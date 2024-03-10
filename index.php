<?php
use App\utils\App;
require_once __DIR__."/vendor/autoload.php";
$config = include __DIR__."/config/config.php";
const APP_MODE_TEST = false;
App::setMode(APP_MODE_TEST);
(new App())->run($config);

