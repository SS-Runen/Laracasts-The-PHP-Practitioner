<?php

// namespace Core;

use App\AppSpecific\App;

require_once "./AppSpecific/App.php";

App::set(
    $alias="default_database",
    $dependency=[
        "dsn" => "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
        "username" => "admin",
        "password" => "vVYb9mvF",
        "options" => []
    ]
);
?>