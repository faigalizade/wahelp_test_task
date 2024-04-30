<?php

use App\Application;
use App\Console;

require_once "vendor/autoload.php";

$app = new Application(true);
$arguments = $argv;
array_shift($arguments);
new Console($arguments);
exit(0);