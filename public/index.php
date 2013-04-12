<?php

use system\FMVC;
require '../application/config.php';
require_once '../system/FMVC.class.php';




$app = new FMVC($route_array);
$app->run();




