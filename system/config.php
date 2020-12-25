<?php

define('APP_NAME', 'CloudSystem');
define("BASE_URL", "http://localhost/CloudComputingSystem/");
define("BASE_DIR", "/CloudComputingSystem/");

$tmp = explode('?', strtolower($_SERVER['REQUEST_URI']));
define('CURRENT_ROUTE', str_replace(BASE_DIR,'',$tmp[0]));

define('DB_HOST', 'localhost');
define('DB_NAME', 'cloudsystem');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
